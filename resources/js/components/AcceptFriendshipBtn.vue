<template>
    <div>
        <div v-if="localFriendshipStatus === 'pending'">
            <span v-text="sender.name"></span> te ha enviado una solicitud de amistad
            <button
                dusk="accept-friendship"
                @click="acceptFriendshipRequest"
            >Aceptar solicitus
            </button>
            <button
                dusk="deny-friendship"
                @click="denyFriendshipRequest"
            >Denegar solicitud
            </button>
        </div>
        <div v-else-if="localFriendshipStatus === 'accepted'">
            Tú y <span v-text="sender.name"></span> son amigos
        </div>
        <div v-else-if="localFriendshipStatus === 'denied'">
            Solicitud denegada de <span v-text="sender.name"></span>
        </div>
        <div v-if="localFriendshipStatus === 'deleted'">Solicitud eliminada</div>
        <button v-else dusk="delete-friendship" @click="deleteFriendship">Eliminar</button>
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
                    this.localFriendshipStatus = res.data.friendship_status
                })
                .catch(err => {
                    console.log(err.response.data)
                })
        },
        denyFriendshipRequest() {
            axios.delete(`/accept-friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status
                })
                .catch(err => {
                    console.log(err.response.data)
                })
        },
        deleteFriendship() {
            axios.delete(`/friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status
                })
                .catch(err => {
                    console.log(err.response.data)
                })
        },
    },
}
</script>

<style scoped>

</style>
