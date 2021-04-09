<template>
    <div app="id">
		<br>
        <button class="btn btn-primary" @click="isShowUser =! isShowUser"> User </button>
		<button class="btn btn-primary" @click="isShowDegrees =! isShowDegrees"> Degrees </button>
		<br>
        <div v-show="isShowUser">
			<h4>Users:</h4>
			<div class="list_user table-responsive container">
				<table class="table table-hover">
					<thead>
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Email</td>
							<td>Role</td>
							<td v-if="checkIsAdmin">Action</td>
						</tr>
					</thead>
					<tbody v-if="list_users.length">
						<tr v-for="user in list_users" :key="user.id">
							<td>{{ user.id }}</td>
							<td>{{ user.name }}</td>
							<td>{{ user.email }}</td>
							<td>
								<span v-for="role in user.roles" :key="role.id">
									{{ role.name }}
								</span>
							</td>
							<td v-if="checkIsAdmin" > 
								<button class="btn btn-primary" @click="selectUser(user)">
									Edit
								</button>
								<button class="btn btn-danger">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
        </div>

		<div v-show="isShowDegrees">
				<h4>Degrees:</h4>
		</div>

    </div>
</template>

<script>
import Degrees from './Degrees.vue'
   export default {
  components: { Degrees },
       data() {
			return {
				userCreate: {
					name: '',
					email: '',
					role: 'student'
				}, 
                currentUser: {},
                list_users: [],
                isShowUser: true,
				isShowDegrees: true				
				}
		},
		created() {
            this.getCurrentUser()
			this.getListUsers()
			
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
            async getListUsers() {
                const response = await axios.get('http://localhost:8000/users')
                                
                this.list_users = response.data
                this.list_users.forEach(user => {
                    Vue.set(user, 'isEdit', false)
                })                          
			}
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