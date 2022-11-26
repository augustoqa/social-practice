<template>
	<div>
	<div v-for="status in statuses" class="card mb-3 border-0">
		<div class="card-body d-flex flex-column shadow-sm">
			<div class="d-flex align-items-center mb-3">
				<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="40" class="mr-3">
				<div>
					<h5 class="mb-1">Pedro Sal</h5>
					<div class="small text-muted">Hace una hora</div>
				</div>
			</div>
			<p v-text="status.body" class="card-text text-secondary"></p>
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
	}
}
</script>