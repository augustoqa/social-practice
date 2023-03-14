<template>
    <button
        dusk="request-friendship"
        @click="sendFriendshipRequest"
    >
        {{ textBtn }}
    </button>
</template>

<script>
export default {
    name: "FriendshipBtn",
    props: {
        recipient: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            textBtn: 'Solicitar amistad',
        }
    },
    methods: {
        sendFriendshipRequest() {
            axios.post(`/friendships/${this.recipient.name}`)
                .then(res => {
                    this.textBtn = 'Solicitud enviada'
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
