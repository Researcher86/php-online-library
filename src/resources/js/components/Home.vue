<template>
    <div class="row justify-content-center">
        <div class="col-mod-12" v-bind:class="[!loading ? 'd-none' : '']">
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="col-md-3" v-bind:class="[loading ? 'd-none' : '']">
            <div class="card">
                <div class="card-header">Жанры</div>

                <div class="card-body">
                    <div v-for="genre in genres" v-bind:key="genre.id">
                        <a href="javascript:void(0)" v-on:click="selectGenre(genre.id)">{{genre.name}}</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9" v-bind:class="[loading ? 'd-none' : '']">
            <books :genre="genre"></books>
        </div>
    </div>
</template>

<script>
    import Books from './Books.vue';
    export default {
        components: { Books },
        data() {
            return {
                genres: [],
                genre: null,
                loading: true
            }
        },
        created() {
            this.fetchGenres();
        },

        methods: {
            fetchGenres() {
                fetch('api/genres')
                    .then(res => res.json())
                    .then(res => {
                        this.genres = res;
                        this.loading = false;
                    })
                    .catch(err => console.log(err));
            },
            selectGenre(genre) {
                this.genre = genre;
                // alert(genre);
            }
        }
    }
</script>
