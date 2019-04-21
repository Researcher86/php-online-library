<template>
    <vue-select label="name" :filterable="false" :options="options" @search="onSearch">
    </vue-select>
</template>


<script>
    import VueSelect from 'vue-select';

    export default {
        components: {
            VueSelect
        },
        data() {
            return {
                mutableLoading: true,
                options: [],
                result: ""
            }
        },
        methods: {
            onSearch(search, loading) {
                loading(true);
                this.search(loading, search, this);
            },
            search: _.debounce((loading, search, vm) => {
                fetch(
                    `https://api.github.com/search/repositories?q=${escape(search)}`
                ).then(res => {
                    res.json().then(json => (vm.options = json.items));
                    loading(false);
                });
            }, 350)
        }
    }
</script>