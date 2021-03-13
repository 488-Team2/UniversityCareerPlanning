<template>
   <div class="user-management">
        <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar=brand" href="#">University Career Planning</a>
            </div>
            <div class="row">
                <div class="col">

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" v-if="checkIsAdmin"><a class="nav-link" href="/admin/dashboard"> {{ currentUser.name }}</a></li>
						<li class="nav-item" v-else-if="!checkIsAdmin"><a class="nav-link" href="/student/dashboard"> {{ currentUser.name }}</a></li>
                        <li class="nav-item"><a class="nav-link" >|</a></li>
                        <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </nav>
   </div>
</template>

<script>
   export default {
       data() {
			return {
				currentUser: {}		
				}
		},
		created() {
			this.getCurrentUser()
		},
		methods: {
			async getCurrentUser() {
	    		axios.get('http://localhost:8000/getCurrentUser')
				.then(response => {
					this.currentUser = response.data
				})
				.catch(error => {
					console.log(error)
				})
	    	},
		},
		computed: {
			checkIsAdmin() {
				if(this.currentUser.roles) {
					let check = false
					this.currentUser.roles.forEach(role => {
						if(role.name === 'admin') {
							check = true
						}
					})
					return check
				}
			}
		}
   }
</script>

<style lang="scss" scoped>
</style>