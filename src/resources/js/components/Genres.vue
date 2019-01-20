<template>
    <div class="card">
        <div class="card-header">Жанры</div>

        <div class="card-body">
            <div v-for="genre in genres" v-bind:key="genre.id">
                <a href="#">{{genre.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                genres: []
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
            }
        }
    }
</script>
