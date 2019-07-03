<?php

namespace App\Services\Book\Index\Elastic;


use App\Models\Book\Book;
use App\Services\Book\Index\IndexBookServiceInterface;
use App\Services\Book\Index\Response;
use Elasticsearch\Client;
use Psr\Log\LoggerInterface;

class ElasticIndexBookService implements IndexBookServiceInterface
{
    private const INDEX = 'library';
    private const TYPE = 'books';
    private $client;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ElasticIndexBookService constructor.
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }


    public function add(Book $book): bool
    {
        $response = $this->client->index([
            'index' => self::INDEX,
            'type' => self::TYPE,
            'id' => $book->id,
            'body' => [
                'title' => $book->title,
                'annotation' => $book->annotation,
                'genre' => $book->getGenresNames(),
                'author' => $book->getAuthorsNames()
            ],
        ]);
        $this->refresh();

        return in_array($response['result'], ['created', 'updated']);
    }

    public function delete(int $id): bool
    {
        $response = $this->client->delete(['index' => self::INDEX, 'type' => self::TYPE, 'id' => $id]);
        $this->refresh();
        return $response['result'] === 'deleted';
    }


    public function restore(): void
    {
        $this->deleteIndex();
        $this->createIndex();
        $this->logger->info('Restore index success');
    }

    public function search(string $text, int $page, int $limit): Response
    {
        $response = $this->client->search([
            'index' => self::INDEX,
            'type' => self::TYPE,
            'body' => [
                '_source' => [''],
                'from' => ($page - 1) * $limit,
                'size' => $limit,
                'query' => [
                    'multi_match' => [
                        'query' => $text,
                        'fields' => ['title^4', 'author^3', 'genre^2', 'annotation^1']
                    ]
                ],
                'highlight' => [
                    'fields' => [
                        '*' => [
                            'fragment_size' => 150,
                            'number_of_fragments' => 4,
                            'pre_tags' => ['<b>'],
                            'post_tags' => ['</b>'],
                            "require_field_match" => true,
                        ]
                    ]
                ]
            ]
        ]);

        $this->logger->debug('ElasticSearch:', $this->client->transport->getLastConnection()->getLastRequestInfo());

        $books = $this->getBooks($response);
        return new Response($response['hits']['total'], $books);
    }

    private function getBooks(array $response)
    {
        $ids = array_map('intval', array_column($response['hits']['hits'], '_id'));

        if (empty($ids)) {
            return [];
        }

        $books = Book::getByIds($ids);

        $books->map(function ($book) use ($response) {
            $result = array_filter($response['hits']['hits'], function ($item) use ($book) {
                return $item['_id'] == $book->id;
            });
            $book->highlight = $result[0]['highlight'] ?? null;

            return $book;
        });

        return $books->all();
    }

    public function count(): int
    {
        $response = $this->client->count(['index' => self::INDEX, 'type' => self::TYPE]);
        return $response['count'];
    }

    private function createIndex()
    {
        $mappings = [
            'index' => self::INDEX,
            'body' => [
                'mappings' => [
                    self::TYPE => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'genre' => [
                                'type' => 'text'
                            ],
                            'title' => [
                                'type' => 'text'
                            ],
                            'author' => [
//                                'type' => 'keyword', // Ищет по полному совпадению
                                'type' => 'text', // Ищет по части слова
                            ],
                            'annotation' => [
                                'type' => 'text', // Ищет по части слова
                            ]
                        ]
                    ]
                ],
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2,
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'trigrams' => [
                                'type' => 'ngram',
                                'min_gram' => 4,
                                'max_gram' => 6,
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'trigrams',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ];

        $response = $this->client->indices()->create($mappings);
        $this->logger->info('Create index', $response);

        // Get settings for one index
        $response = $this->client->indices()->getSettings(['index' => self::INDEX]);
        $this->logger->info('Add settings', $response);

        // Get mapping 'my_type' in 'my_index'
        $response = $this->client->indices()->getMapping(['index' => self::INDEX, 'type' => self::TYPE]);
        $this->logger->info('Add mappings', $response);
    }

    private function deleteIndex()
    {
        if ($this->client->indices()->exists(['index' => self::INDEX])) {
            $response = $this->client->indices()->delete(['index' => self::INDEX]);
            $this->logger->info('Delete index', $response);
        }
    }

    /**
     * Refreshes elasticsearch index.
     *
     * @param array $params
     *
     * @return array
     */
    private function refresh(array $params = [])
    {
        return $this->client->indices()->refresh(array_merge(['index' => self::INDEX], $params));
    }
}