<template>
    <div>
        <div v-for="comment in comments" class="mb-3">
            <div class="d-flex">
                <img
                    :src="comment.user.avatar"
                    :alt="comment.user.name"
                    width="34px"
                    height="34px"
                    class="shadow-sm float-left mr-2"
                />
                <div class="flex-grow-1">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-2 text-secondary">
                            <a :href="comment.user.link"
                                ><strong>{{ comment.user.name }}</strong></a
                            >
                            {{ comment.body }}
                        </div>
                    </div>
                    <span
                        dusk="comment-likes-count"
                        class="float-right badge badge-pill badge-primary py-1 px-2 mt-1"
                    >
                        <i class="fa fa-thumbs-up"></i>
                        {{ comment.likes_count }}
                    </span>
                    <like-btn
                        dusk="comment-like-btn"
                        :url="`/comments/${comment.id}/likes`"
                        :model="comment"
                        class="comments-like-btn"
                    ></like-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LikeBtn from "./LikeBtn";

export default {
    props: {
        comments: {
            type: Array,
            required: true
        },
        statusId: {
            type: Number,
            required: true,
        },
    },
    components: { LikeBtn },
    mounted() {
        Echo.channel(`statuses.${this.statusId}.comments`)
            .listen('CommentCreated', ({ comment }) => {
                this.comments.push(comment)
            })

        EventBus.$on(`statuses.${this.statusId}.comments`, comment => {
            this.comments.push(comment)
        })
    },
};
</script>
