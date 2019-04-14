<template>
    <star-rating v-bind:increment="0.5" v-bind:show-rating="false" v-bind:star-size="20" v-model="rating" @rating-selected="setRating($event, id)"></star-rating>
</template>

<script>
    import StarRating from 'vue-star-rating'
    export default {
        components: {
            StarRating
        },

        props: ['id', 'rating'],

        methods: {
            setRating: function(r, id){
                axios.post(`/books/${id}/rating/${r}`)
                    .then(res => {
                        alert(res.data.msg);
                    })
                    .catch(err => {
                        if (err.response.status === 400) {
                            alert(err.response.data);
                        } else {
                            console.log(err);
                        }
                    });
            },
        }
    }
</script>
