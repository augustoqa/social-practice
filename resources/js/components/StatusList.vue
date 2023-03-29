<template>
	<div @click="redirectIfGuest">
        <status-list-item
            v-for="status in statuses"
            :status="status"
            :key="status.id"
        ></status-list-item>
    </div>
</template>

<script>
import StatusListItem from "./StatusListItem";

export default {
    components: {
        StatusListItem
    },
    props: {
        url: String,
    },
	data() {
		return {
			statuses: [],
		}
	},
	mounted() {
		axios.get(this.getUrl)
			.then(res => {
				this.statuses = res.data.data
			})
			.catch(err => {
				console.log(err.response.data)
			})
		EventBus.$on('status-created', data => {
			this.statuses.unshift(data)
		})
	},
    computed: {
        getUrl() {
            return this.url ? this.url : '/statuses'
        },
    },
}
</script>
