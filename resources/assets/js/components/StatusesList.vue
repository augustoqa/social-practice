<template>
	<div @click="redirectIfGuest">
	<div v-for="status in statuses" class="card mb-3 border-0 shadow-sm">
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
        <div class="card-footer p-2">
            <button
                v-if="status.is_liked"
                @click="unlike(status)"
                class="btn btn-link btn-sm"
                dusk="unlike-btn"
            >
                <strong>
                    <i class="fa-solid fa-thumbs-up"></i>
                    TE GUSTA
                </strong>
            </button>
            <button
                v-else
                @click="like(status)"
                class="btn btn-link btn-sm"
                dusk="like-btn"
            >
                <i class="fa-regular fa-thumbs-up"></i>
                ME GUSTA
            </button>
            <span dusk="likes-count">{{ status.likes_count }}</span>
        </div>
	</div>
</div>
</template>

<script>
export default {
	data() {
		return {
			statuses: [],
		}
	},
	mounted() {
		axios.get('/statuses')
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
	methods: {
		like(status) {
			axios.post(`/statuses/${status.id}/likes`)
				.then(res => {
					status.is_liked = true
                    status.likes_count++
				})
		},
		unlike(status) {
			axios.delete(`/statuses/${status.id}/likes`)
				.then(res => {
					status.is_liked = false
                    status.likes_count--
				})
		}
	}
}
</script>
