<template>
    <div class="row">
        <div class="col-3 mb-4" v-for="book in books" v-bind:key="book.id">
            <div class="card">
                <img class="card-img-top" src="/img/books/07139043.cover_250.jpg" alt="Card image cap">
                <div class="card-body">
                    <h6 class="card-title">{{book.title.slice(0, 20)}}</h6>
                    <i class="far fa-eye">12</i>
                    <a href="#"><i class="fas fa-book-open"></i></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: []
            }
        },
        created() {
            this.fetchBooks();
        },

        methods: {
            fetchBooks() {
                fetch('api/books')
                    .then(res => res.json())
                    .then(res => {
                        this.books = res;
                    })
                    .catch(err => console.log(err));
            }
        }
    }
</script>
