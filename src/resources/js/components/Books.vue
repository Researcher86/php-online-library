<template>
    <div class="row book-list">
        <div class="col-3 mb-4" v-for="book in books" v-bind:key="book.id">
            <div class="card">
                <img class="card-img-top" :src="book.image" :alt="book.title">
                <div class="card-body">
                    <h6 class="card-title">{{book.title.slice(0, 20)}}</h6>
                    <star-rating class="mb-3" v-bind:show-rating="false" v-bind:star-size="25" v-model="book.rating" @rating-selected="setRating($event, book)"></star-rating>
                    <i class="far fa-eye">12</i>
                    <a href="#"><i class="fas fa-book-open"></i></a>
                </div>
            </div>
        </div>
        <div class="col-12" v-if="pagination.last_page > 1">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="javascript:void(0)" @click="fetchBooks(pagination.prev_page_url)">Previous</a></li>

                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="javascript:void(0)" @click="fetchBooks(pagination.next_page_url)">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating'
    export default {
        components: {
            StarRating
        },

        props: ['genre'],

        watch:{
            genre: function () {
                this.fetchBooks();
            }
        },

        data() {
            return {
                books: [],
                rating: 0,
                pagination: {},
            }
        },
        created() {
            this.fetchBooks();
        },
        methods: {
            setRating: function(rating, book){
                axios.post(`api/books/${book.id}/rating/${rating}`)
                    .then(res => {
                        book.rating = res.data;
                    })
                    .catch(err => console.log(err));
            },
            fetchBooks(page_url) {
                let vm = this;
                page_url = page_url || (this.genre ? `/api/books/genres/${this.genre}` : '/api/books');

                axios.get(page_url)
                    .then(res => {
                        this.books = res.data.data;
                        vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };
                this.pagination = pagination;
            },
        }
    }
</script>
