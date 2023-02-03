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
    }
}
</script>

<style scoped>

</style>
