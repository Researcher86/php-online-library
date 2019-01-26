<template>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Жанры</div>

                <div class="card-body">
                    <div v-for="genre in genres" v-bind:key="genre.id">
                        <a href="javascript:void(0)" v-on:click="selectGenre(genre.id)">{{genre.name}}</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9">
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
