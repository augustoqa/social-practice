<template>
    <div v-if="localFriendshipStatus === 'pending'">
        <span v-text="sender.name"></span> te ha enviado una solicitud de amistad
        <button
            dusk="accept-friendship"
            @click="acceptFriendshipRequest"
        >Aceptar solicitus</button>
    </div>
    <div v-else>
        Tú y <span v-text="sender.name"></span> son amigos
    </div>
</template>

<script>
export default {
    name: "AcceptFriendshipBtn",
    props: {
        sender: {
            type: Object,
            required: true,
        },
        friendshipStatus: {
            type: String,
            require: true,
        },
    },
    data() {
        return {
            localFriendshipStatus: this.friendshipStatus
        }
    },
    methods: {
        acceptFriendshipRequest() {
            axios.post(`/accept-friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = 'accepted'
                })
                .catch(err => {
                    console.log(err.response.data)
                })
        }
    },
}
</script>

<style scoped>

</style>
