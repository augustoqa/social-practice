<template>
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <img :src="status.user.avatar" width="40" class="mr-3" :alt="status.user.name">
                <div>
                    <h5 class="mb-1"><a :href="status.user.link" v-text="status.user.name"></a></h5>
                    <div class="small text-muted" v-text="status.ago"></div>
                </div>
            </div>
            <p v-text="status.body" class="card-text text-secondary"></p>
        </div>
        <div class="card-footer p-2 d-flex justify-content-between align-items-center">

            <like-btn
                dusk="like-btn"
                :url="`/statuses/${status.id}/likes`"
                :model="status"
            ></like-btn>

            <div class="text-secondary mr-2">
                <i class="fa-regular fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <div class="card-footer pb-0" v-if="isAuthenticated || status.comments.length">
            <comment-list
                :comments="status.comments"
                :statusId="status.id"
            ></comment-list>
            <comment-form :status-id="status.id"></comment-form>
        </div>
    </div>
</template>

<script>
import LikeBtn from "./LikeBtn";
import CommentList from "./CommentList"
import CommentForm from "./CommentForm";

export default {
    props: {
        status: {
            type: Object,
            required: true,
        }
    },
    components: {
        LikeBtn,
        CommentList,
        CommentForm,
    },
}
</script>

<style scoped>

</style>
