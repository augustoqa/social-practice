<template>
    <form @submit.prevent="addComment" v-if="isAuthenticated" class="mb-3">
        <div class="d-flex align-items-center">
            <img
                :src="currentUser.avatar"
                :alt="currentUser.name" width="34px" class="shadow-sm mr-2">
            <div class="input-group">
                        <textarea
                            v-model="newComment"
                            class="form-control border-0 shadow-sm"
                            name="comment"
                            placeholder="Escribe un comentario"
                            rows="1"
                            required
                        ></textarea>
                <div class="input-group-append">
                    <button dusk="comment-btn" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </form>
    <div v-else class="mb-3 text-center">
        Debes <a href="/login">autenticarte</a> para poder comentar
    </div>
</template>

<script>
export default {
    name: "CommentForm",
    props: {
        statusId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            newComment: '',
        }
    },
    methods: {
        addComment() {
            axios.post(`/statuses/${this.statusId}/comments`, { body: this.newComment })
                .then(res => {
                    EventBus.$emit(`statuses.${this.statusId}.comments`, res.data.data)
                    this.newComment = ''
                })
                .catch(err => {
                    console.log(err.response.data);
                })
        },
    },
}
</script>

<style scoped>

</style>
