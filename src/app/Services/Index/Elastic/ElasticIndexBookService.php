<?php

namespace App\Services\Index\Elastic;


use App\Models\Book\Book;
use App\Services\Index\IndexBookServiceInterface;
use Elasticsearch\Client;
use Psr\Log\LoggerInterface;
use stdClass;

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


    public function add(Book $book)
    {
        return $this->client->index([
            'index' => self::INDEX,
            'type' => self::TYPE,
            'id' => $book->id,
            'body' => [
                'genre' => $book->getGenres()->get(0)->name,
                'title' => $book->title,
                'author' => $book->getAuthors()->get(0)->name,
                'annotation' => $book->annotation,
            ],
        ]);
    }

    public function delete(Book $book)
    {
        $this->client->delete(['index' => self::INDEX, 'type' => self::TYPE, 'id' => $book->id]);
    }


    public function restore()
    {
        $this->deleteIndex();
        $this->createIndex();
        $this->logger->info('Restore index success');
    }

    public function searchByTitle(string $title)
    {
        return $this->searchByQuery([
            'match' => [
                'title' => $title
            ]
        ]);
    }

    public function searchByAuthor(string $name)
    {
        return $this->searchByQuery([
            'match' => [
                'author' => $name
            ]
        ]);
    }

    public function searchByAnnotation(string $annotation)
    {
        return $this->searchByQuery([
            'match' => [
                'annotation' => $annotation
            ]
        ]);
    }

    public function count()
    {
        $response = $this->client->count(['index' => self::INDEX, 'type' => self::TYPE]);
        return $response['count'];
    }

    private function searchByQuery(array $query)
    {
        $response = $this->client->search([
            'index' => self::INDEX,
            'type' => self::TYPE,
            'body' => [
                'query' => $query,
                'highlight' => [
                    'number_of_fragments' => 0,
                    'fragment_size' => 150,
                    'pre_tags' => ['<strong>'],
                    'post_tags' => ['</strong>'],
                    "require_field_match" => true,
                    'fields' => [
                        '*' => new stdClass(),
//                        self::TYPE . '.title' => ['number_of_fragments' => 0],
//                        self::TYPE . '.author' => ['number_of_fragments' => 0],
//                        self::TYPE . '.description' => ['number_of_fragments' => 5, 'order' => 'score']
                    ]
                ]
            ]
        ]);

        return $this->getBooks($response);
    }

    private function getBooks(array $response): array
    {
        $books = array_map(function ($item) {
            return $item['_source'];
        }, $response['hits']['hits']);

        return $books;
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
}