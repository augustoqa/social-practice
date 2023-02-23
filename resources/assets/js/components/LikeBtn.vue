<template>
    <button
        @click="toggle()"
        :class="getBtnClasses"
    >
        <i :class="getIconClasses"></i>
        {{ getText }}
    </button>
</template>

<script>
export default {
    props: {
        model: {
            type: Object,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
    },
    methods: {
        toggle() {
            let method = this.model.is_liked ? 'delete' : 'post'
            axios[method](this.url)
                .then(res => {
                    this.model.is_liked = ! this.model.is_liked
                    if (method === 'post') 
                    {
                        this.model.likes_count++
                    } else {
                        this.model.likes_count--
                    }
                })
        },
    },
    computed: {
        getText() {
            return this.model.is_liked ? 'TE GUSTA' : 'ME GUSTA'
        },
        getBtnClases() {
            return [
                this.model.is_liked ? 'font-weight-bold' : '',
                'btn', 'btn-link', 'btn-sm' 
            ]
        },
        getIconClases() {
            return [
                this.model.is_liked ? 'fa-regular' : 'fa-solid', 
                'fa-thumbs-up'
            ]
        }
    },
}
</script>

<style scoped>

</style>
