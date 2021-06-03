<template>
    <div>

		<FlashMessage :position="'right top'"></FlashMessage>
		<button class="add" @click="isShow =! isShow">NEW USER: </button>
		<div v-show="isShow">
		
		<div class="shadow p-3 mb-5 bg-white rounded">
		<div class="card mt-3">
	    <div class="card-body" v-if="checkIsAdmin">
				<div class="form-group row">
				<h6>CREATE NEW USER: </h6>
				</div><br>
				
        		<div class="form-group row">
        			<label class="col-3">Name </label>
					<div class="col-9">
						<input data-test="userNameText" type="text" v-model="user.name" class="form-control" >
					</div>
        		</div>

				<br>
        		<div class="form-group row">
					<label class="col-3">Email </label>
					<div class="col-9">
        			<input data-test="userEmailText" type="email" v-model="user.email" class="form-control" >
					</div>
        		</div>

				<br>
        		<div class="form-group row">
					<label class="col-3">Dept. Id </label>
					<div class="col-9">
        			<input data-test="userDeptIdText" type="text" v-model="user.department_id" class="form-control" >
					</div>
        		</div>

				<br>
        		<div class="form-group row">
					<label class="col-3">Role </label>
					<div class="col-9">
        			<select data-test="userRoleText" class="form-control" v-model="user.role" >
        				<option value="student">Student</option>
        				<option value="user">User</option>
        				<option value="admin">Admin</option>
        			</select>
					</div>
        		</div>

				<br>
				<div class="form-group row">
					<label class="col-3">User Type </label>
					<div class="col-9">
        			<select data-test="userAccountTypeText" class="form-control" v-model="user.account_type" >
        				<option value="student">Student</option>
        				<option value="user">User</option>
        				<option value="admin">Admin</option>
        			</select>
					</div>
        		</div>

				<br>
        		<div class="form-group row">
					<div class="col-3" ></div>
					<div class="col-9">
        			<button data-test="createBtn" class="btn btn-primary" @click="createUser(), flashMessage.success({ message:'Successfully created '+user.name+ '|email: '+ user.email, time:4000 });">Create User</button>
					</div>
        		</div>
	    
        </div>
		</div>
		</div>
		</div>
        <!-- Table Create User -->
		<br>
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
                	
					<div class = "col-md-5">
						<div class="input-group">
							<input data-test="userSearchText" type="text" v-model="search" v-on:keyup.enter="searchUser()" class="form-control" placeholder="name, email, dept. id, role...">
							<div class="input-group-prepend">
								<button @click.prevent="searchUser()" class="btn btn-primary">Search</button>
							</div>
						</div>
					</div>
					<br />

					<div v-if="showSearch==true"> 
						<button class="btn btn-outline-primary" @click="reloadPage()">Refresh</button>

						<div v-if="searchArr.length"> 
						<h4>Result(s): {{ searchArr.length }} </h4> 
						<div class="row">
						  <div class="search table-responsive container">
								<table class="table table-hover">
								<thead>
									<tr>
										<td>ID</td>
										<td>Name</td>
										<td>Email</td>
										<td>Dept. Id</td>
										<td>Role</td>
										<td>User Since</td>
										<td v-if="checkIsAdmin">Action</td>
									</tr>
								</thead>
								<transition-group name="slide-fade" tag="tbody">
									<tr v-for="( sear,index1 ) in searchArr" v-bind:key="sear.id">
										<td >{{ sear.id }}</td>

										<td v-if="!sear.isEdit">{{ sear.name }}</td>
										<td v-else>
											<input type="text" v-model="selectedUser.name" class="form-control">
										</td>

										<td v-if="!sear.isEdit">{{ sear.email }}</td>
										<td v-else>
											<input type="text" v-model="selectedUser.email" class="form-control">
										</td>

										<td v-if="!sear.isEdit">{{ sear.department_id }}</td>
										<td v-else>
											<input type="text" v-model="selectedUser.department_id" class="form-control">
										</td>								

										<td v-if="!sear.isEdit">{{ sear.account_type }}</td>
										<td v-else>
											<input type="text" v-model="selectedUser.account_type" class="form-control">
										</td>

										<td v-if="!sear.isEdit">{{ moment(sear.created_at).format("LL") }}</td>
										<td v-else>
											{{ moment(sear.created_at).format("LL") }}
										</td>

										<td v-if="checkIsAdmin && !sear.isEdit" > 
											<button class="btn btn-primary" @click="selectUser(sear)">Edit</button>
											<button class="btn btn-danger" @click="deleteUser(sear, index1)">Delete</button>
										</td>
										<td v-else>
											<button class="btn btn-primary" @click="updateUser(sear)">Save</button>
											<button class="btn btn-danger" @click="sear.isEdit = false">Cancel</button>
										</td>
						
									</tr>
								</transition-group>
								</table>
		
							</div>


						</div>
						</div>
						<div v-else>
							<h4>No result found.</h4>
						</div>

					</div>
		<!--end Search User -->

			<div v-if="showSearch==false"> 
					<h4>Manage Users: {{ list_users.length }} </h4>
					<div class="list_user table-responsive container">
						<table class="table table-hover">
						<thead>
							<tr>
								<td>ID</td>
								<td>Name</td>
								<td>Email</td>
								<td>Dept. Id</td>
								<td>Role</td>
								<td>User Since</td>
								<td v-if="checkIsAdmin">Action</td>
							</tr>
						</thead>
						 <transition-group name="slide-fade" tag="tbody">
						<!-- <tbody v-if="list_users.length"> -->
							<tr v-for="(user, index) in list_users.data" :key="user.id">
								<td>{{ user.id }}</td>

								<td v-if="!user.isEdit">{{ user.name }}</td>
								<td v-else>
									<input type="text" v-model="selectedUser.name" class="form-control">
								</td>

								<td v-if="!user.isEdit">{{ user.email }}</td>
								<td v-else>
									<input type="text" v-model="selectedUser.email" class="form-control">
								</td>

								<td v-if="!user.isEdit">{{ user.department_id }}</td>
								<td v-else>
									<input type="text" v-model="selectedUser.department_id" class="form-control">
								</td>

								<td v-if="!user.isEdit">{{ user.account_type }}</td>
								<td v-else>
									<input type="text" v-model="selectedUser.account_type" class="form-control">
								</td>

								<td v-if="!user.isEdit">{{ moment(user.created_at).format("LL") }}</td>
								<td v-else>
									{{ moment(user.created_at).format("LL") }}
								</td>

								<td v-if="checkIsAdmin && !user.isEdit" > 
									<button class="btn btn-primary" @click="selectUser(user)">Edit</button>
									<button class="btn btn-danger" @click="deleteUser(user, index)">Delete</button>
								</td>
								 <td v-else>
									<button class="btn btn-primary" @click="updateUser(index), flashMessage.success({ title: 'Success', message: user.name + ' is updated!', time:1000 });">Save</button>
									<button class="btn btn-danger" @click="user.isEdit = false">Cancel</button>
								</td>
							</tr>
						<!-- </tbody> -->
						</transition-group>
					</table>
			<div>
			{{ list_users.from }} - {{ list_users.to }} of {{ list_users.total }}
			</div>
			<ul class="pagination">
				<li
					class="page-item"
					:class="{ 'disabled': list_users.prev_page_url === null }"
					@click="list_users.prev_page_url && getListUsers(list_users.current_page - 1)"
				>
					<a class="page-link" href="#">Previous</a>
				</li>
				<li class="page-item" v-if="list_users.prev_page_url" @click="getListUsers(list_users.current_page - 1)">
					<a class="page-link" href="#">{{ list_users.current_page - 1 }}</a>
				</li>
				<li class="page-item active">
					<a class="page-link" href="#">{{ list_users.current_page }}</a>
				</li>
				<li class="page-item" v-if="list_users.next_page_url" @click="getListUsers(list_users.current_page + 1)">
					<a class="page-link" href="#">{{ list_users.current_page + 1 }}</a>
				</li>
				<li
					class="page-item"
					:class="{ 'disabled': list_users.next_page_url === null }"
					@click="list_users.next_page_url && getListUsers(list_users.current_page + 1)"
				>
					<a class="page-link" href="#">Next</a>
				</li>
			</ul>
			</div>

            </div>
		<!--end List User -->

            </div>
            <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<br>
					<a href="/apiDegree"> Go to Degrees </a>

            </div>
        </div>


    </div>
</template>

<script>
import axios from 'axios';
import Degrees from './Degrees.vue'
   export default {
  components: { Degrees },
       data() {
			return {
				user: {
					name: '',
					email: '',
					role: 'student',
					department_id: 0,
					account_type: ''
				//	created_at: ''
				}, 
                currentUser: {},
				list_users: {},

				selectedUser: null,
				search: '',
				showSearch: false,
				searchArr: [],
				isShow: false
			//	listUsers: {}
			//	moment: moment			
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
            async getListUsers(page = 1) {
                const response = await axios.get('/api/users?page=' + page)
                this.list_users = response.data
                this.list_users.data.forEach(user => {
                    Vue.set( user, 'isEdit', false)
                }, error => {
					console.log(error.response.data)
				})                         
			},
			async createUser() {
				axios.post('/api/user/create', { user: this.user })
				.then(response => {
					console.log(response)
					this.list_users.data.unshift( {
						...response.data.user,
						isEdit: false
					})
					this.user = {}
					//this.getListUsers()
				})
				.catch( error => {
					 console.log(error)
				/*	if (error.response.status == 422){
						this.err = error.response.data;
					}*/
	
				})	

			},
			selectUser(user) {
				user.isEdit = true
				this.selectedUser = { ...user }
			},
			async updateUser(index) {
				try {
			    const response = await axios.put('/api/user/update/' + this.selectedUser.id, {
					name: this.selectedUser.name,
					email: this.selectedUser.email,
					role : this.selectedUser.role,
					department_id: this.selectedUser.department_id,
					account_type: this.selectedUser.account_type
				})
				this.list_users.data[index].name = response.data.user.name
				this.list_users.data[index].email = response.data.user.email
				this.list_users.data[index].role = response.data.user.role
				this.list_users.data[index].department_id = response.data.user.department_id
				this.list_users.data[index].account_type = response.data.user.account_type
				this.list_users.data[index].isEdit = false

				} catch(error) {
					console.log(error)
				}
			},
			async deleteUser(user, index) {
				try {
					if(confirm("Do you really want to delete this " + user.name+ " from the system?")){
						await axios.delete('/api/user/delete/' + user.id)
						this.list_users.data.splice(index, 1)
						this.flashMessage.show({
							status: 'error',
							message: user.name + " is deleted!"
						});
					}

				}catch (error) {
					console.log(error)
				}
			},
			searchUser() {
				fetch('/api/user/search?q='+this.search)
				.then(res => res.json())
				.then(res => {
					this.searchArr = res;
					this.search = '';
					this.showSearch = true;
				})
				.catch(error => {
					console.log(error)
				});
			},
			reloadPage() {
				window.location.reload();
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
#btt {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  display: flex;
  flex-flow: column;
  align-items: center;
}

button.add {
  border-radius: 10px;
  background-color: rgba(1, 148, 122, 0.68);
  border-color: #01947a;
  text-align: center;
  color: white;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all .2s ease;
}

.slide-fade-leave-active {
    transition: all .6s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}

</style>