<template>
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="40" class="mr-3">
                <div>
                    <h5 class="mb-1" v-text="status.user_name"></h5>
                    <div class="small text-muted" v-text="status.ago"></div>
                </div>
            </div>
            <p v-text="status.body" class="card-text text-secondary"></p>
        </div>
        <div class="card-footer p-2 d-flex justify-content-between align-items-center">

            <like-btn :status="status"></like-btn>

            <div class="text-secondary mr-2">
                <i class="fa-regular fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <div class="card-footer">
            <div v-for="comment in comments" class="mb-3">
                <img :src="comment.user_avatar" :alt="comment.user_name"
                     width="34px" class="shadow-sm float-left mr-2">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-2 text-secondary">
                        <a href="#"><strong>{{ comment.user_name }}</strong></a>
                        {{ comment.body }}
                    </div>
                </div>
            </div>
            <form @submit.prevent="addComment" v-if="isAuthenticated">
                <div class="d-flex align-items-center">
                    <img
                        src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                        :alt="currentUser.name" width="34px" class="shadow-sm mr-2">
                    <div class="input-group">
                        <textarea
                            v-model="newComment"
                            class="form-control border-0 shadow-sm"
                            name="comment"
                            placeholder="Escribe un comentario.."
                            rows="1"
                            required
                        ></textarea>
                        <div class="input-group-append">
                            <button dusk="comment-btn" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import LikeBtn from "./LikeBtn";

export default {
    props: {
        status: {
            type: Object,
            required: true,
        }
    },
    components: {
        LikeBtn
    },
    data() {
        return {
            newComment: '',
            comments: this.status.comments,
        }
    },
    methods: {
        addComment() {
            axios.post(`/statuses/${this.status.id}/comments`, { body: this.newComment })
                .then(() => {
                    this.comments.push(this.newComment)
                    this.newComment = ''
                })
                .catch(err => {
                    console.log(err.response.data);
                })
        }
    }
}
</script>

<style scoped>

</style>
