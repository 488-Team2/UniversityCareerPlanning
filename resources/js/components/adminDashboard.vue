<template>
    <div app="id">
		<br>
        <hr>
	    <div class="create-user container" v-if="checkIsAdmin">
        	<div class="row">
        		<div class="col-md-3">
        			<input type="text" v-model="userCreate.name" class="form-control" placeholder="Name...">
        		</div>
        		<div class="col-md-3">
        			<input type="email" v-model="userCreate.email" class="form-control" placeholder="User email...">
        		</div>
        		<div class="col-md-3">
        			<select class="form-control" v-model="userCreate.account_type">
        				<option value="student">Student</option>
        				<option value="user">User</option>
        				<option value="admin">Admin</option>
        			</select>
        		</div>
        		<div class="col-md-3">
        			<button class="btn btn-primary" @click="createUser">Create</button>
        		</div>
        	</div>
        </div>
        <!-- Table User -->

        <hr>

		<!-- -->
		<br>
		<nav>
            <div class="nav nav-tabs bg-white" id="nav-tab" role="tablist">
                <button class=" nav-link active text-dark " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Users</button>
                <button class="nav-link text-dark" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Degrees</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
				<br>
                	<h4>Users: {{ list_users.length }} </h4>
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

            <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<br>
					<a href="/apiDegree"> Go to Degrees </a>

            </div>
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
					role: 'student',
					department_id: 0,
					email_verified_at: '',
					account_type: ''
				}, 
                currentUser: {},
				list_users: [],
				err: null,

				selectedUser: null,
                isShowUser: true,
				isShowDegrees: true				
				}
		},
		created() {
            this.getCurrentUser();
			this.getListUsers();
			
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
                const response = await axios.get('http://localhost:8000/api/users')
                                
                this.list_users = response.data
                this.list_users.forEach(user => {
                    Vue.set(user, 'isEdit', false)
                }, error => {
					console.log(error)
				})                         
			},
			async createUser() {
				axios.post('/api/user/create', { user: this.userCreate})
				.then(response => {
					console.log(response)
					this.list_users.unshift( {
						...response.data.userCreate,
						isEdit: false
					})
					this.userCreate = {}
					this.getListUsers()
				})
				.catch(error => {
					console.log(error.response.data)
				})

			},
		/*	async createUser() {
				try {
				const response = await axios.post('/users', {
					name: this.userCreate.name,
					email: this.userCreate.email,
					role: this.userCreate.role,
					department_id: this.userCreate.department_id,
					email_verified_at: this.userCreate.email_verified_at,
					account_type: this.userCreate.account_type
				})
					this.list_users.unshift( {
						...response.data.userCreate,
						isEdit: false
					})
					this.userCreate = {
						name: '',
						email: '',
						role: 'student',
						department_id: 0,
						email_verified_at: '',
						account_type: ''
					}
				} catch (error) {
					this.err = error.response.data
				}
				
			},*/
			async selectUser(user) {
				user.isEdit = true
				this.selectedUser = { ...user}
			},
			async updateUser(index) {
				
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