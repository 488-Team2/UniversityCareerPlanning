<template>
        <div class="api-degree container mt-5">
            <h1>Create Degree</h1>
                        <transition name="fade">
                        <div class="alert alert-danger alert-dismissible" role="alert" v-if="error">
                            <b>{{ error.message }}</b>
                            <ul>
                                <li v-for="(errorName, index) in error.errors" :key="index">
                                    {{ errorName[0] }}
                                </li>
                            </ul>
                            <button type="button" class="close" @click="error = null">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        </transition>
                    

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="degree.degree_name" placeholder="Name...">
                    </div><br />
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="degree.degree_description" rows="5" placeholder="Description..."></textarea>
                    </div><br />
                    <div class="form-group">
                        <label>Department Id</label>
                        <input type="text" class="form-control" v-model="degree.department_id" placeholder="id..." >
                    </div><br />
                    <div class="form-group">
                        <label>Graduation Rate</label>
                        <input type="text" class="form-control" v-model="degree.graduation_rate" placeholder="rate...">
                    </div><br />
                    <div class="form-group">
                        <label>Job Demand</label>
                        <input type="text" class="form-control" v-model="degree.job_demand" placeholder="job demand...">
                    </div><br />
                    <div>
                        <button class="btn btn-primary" @click="createDegree">Create</button>
                    </div>

                    <hr>

                    <h1>List Degrees</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Department Id</th>
                                <th scope="col">Graduation Rate</th>
                                <th scope="col">Job Demand</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <transition-group name="slide-fade" tag="tbody">
                            <tr v-for="(degree, index) in listDegrees.data" :key="degree.id">
                                <th scope="row"> {{ degree.id }} </th>
                                <td v-if="!degree.isEdit">{{ degree.degree_name }}</td>
                                <td v-else>
                                    <input type="text" v-model="selectedDegree.degree_name" class="form-control">
                                </td>

                                <td v-if="!degree.isEdit"> {{ degree.degree_description }} </td>
                                <td v-else>
                                    <input type="text" v-model="selectedDegree.degree_description" class="form-control">
                                </td>

                                <td v-if="!degree.isEdit">{{ degree.department_id }}</td>
                                <td v-else>
                                    <input type="text" v-model="selectedDegree.department_id" class="form-control">
                                </td>

                                <td v-if="!degree.isEdit">{{ degree.graduation_rate }}</td>
                                <td v-else>
                                    <input type="text" v-model="selectedDegree.graduation_rate" class="form-control">
                                </td>

                                <td v-if="!degree.isEdit">{{ degree.job_demand }}</td>
                                <td v-else>
                                    <input type="text" v-model="selectedDegree.job_demand" class="form-control">
                                </td>

                                <td v-if="!degree.isEdit">
                                    <button class="btn btn-primary" @click="selectDegree(degree)">Edit</button>
                                    <button class="btn btn-danger" @click="deleteDegree(degree, index)">Delete</button> 
                                </td>
                                <td v-else>
                                    <button class="btn btn-primary" @click="updateDegree(index)">Save</button>
                                    <button class="btn btn-danger" @click="degree.isEdit = false">Cancel</button>
                                </td>
                            </tr>
                        </transition-group>
                    </table>

                    <div>
                        {{ listDegrees.from }} - {{ listDegrees.to }} of {{ listDegrees.total }}
                    </div>
                    <ul class="pagination">
                    <li
                        class="page-item"
                        :class="{ 'disabled': listDegrees.prev_page_url === null }"
                        @click="listDegrees.prev_page_url && getListDegrees(listDegrees.current_page - 1)"
                    >
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item" v-if="listDegrees.prev_page_url" @click="getListDegrees(listDegrees.current_page - 1)">
                        <a class="page-link" href="#">{{ listDegrees.current_page - 1 }}</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">{{ listDegrees.current_page }}</a>
                    </li>
                    <li class="page-item" v-if="listDegrees.next_page_url" @click="getListDegrees(listDegrees.current_page + 1)">
                        <a class="page-link" href="#">{{ listDegrees.current_page + 1 }}</a>
                    </li>
                    <li
                        class="page-item"
                        :class="{ 'disabled': listDegrees.next_page_url === null }"
                        @click="listDegrees.next_page_url && getListDegrees(listDegrees.current_page + 1)"
                    >
                        <a class="page-link" href="#">Next</a>
                    </li>
                    </ul>
    
        </div>
</template>

<script>
    export default {
        data() {
            return {
                degree: {
                    degree_name: '',
                    degree_description: '',
                    department_id: '',
                    graduation_rate: 0,
                    job_demand: 0
        
                },
                listDegrees: {},
                error: null,
                selectedDegree: null
            }
        },
        created() {
            this.getListDegrees()
        },
        methods: {
            async createDegree() {
                try {
                    this.error = null
                    const response = await axios.post('http://localhost:8000/api/degree/create', {
                        degree_name: this.degree.degree_name,
                        degree_description: this.degree.degree_description,
                        department_id: this.degree.department_id,
                        graduation_rate: this.degree.graduation_rate,
                        job_demand: this.degree.job_demand
                    })
                    //this.listDegrees.unshift(esponse.data.degree)
                    //console.log(response.data.degree)
                    this.listDegrees.data.unshift({
                        ...response.data.degree,
                        isEdit: false
                    })

                    //reset form to initial
                    this.degree = {
                        degree_name: '',
                        degree_description: '',
                        department_id: '',
                        graduation_rate: 0,
                        job_demand: 0
                    }
                } catch(error) {
                    this.error = error.response.data
                }
            },
            async getListDegrees(page = 1) {
               try {
                   const response = await axios.get('http://localhost:8000/api/degreeDisplay?page=' + page)
                   this.listDegrees = response.data
                   this.listDegrees.data.forEach(item => {
                        Vue.set(item, 'isEdit', false)
                    })
               } catch (error) {
                   this.error = error.response.data
               }     
          },
          selectDegree(degree) {
              degree.isEdit = true
              this.selectedDegree = { ...degree }
          },
          async updateDegree(index) {
                try {
                    const response = await axios.put('http://localhost:8000/api/degree/update/' + this.selectedDegree.id, {
                        degree_name: this.selectedDegree.degree_name,
                        degree_description: this.selectedDegree.degree_description,
                        department_id: this.selectedDegree.department_id,
                        graduation_rate: this.selectedDegree.graduation_rate,
                        job_demand: this.selectedDegree.job_demand
                    })
                  
                    this.listDegrees.data[index].degree_name = response.data.degree.degree_name
                    this.listDegrees.data[index].degree_description = response.data.degree.degree_description
                    this.listDegrees.data[index].department_id = response.data.degree.department_id
                    this.listDegrees.data[index].graduation_rate = response.data.degree.graduation_rate
                    this.listDegrees.data[index].job_demand = response.data.degree.job_demand
                    this.listDegrees.data[index].isEdit = false

                } catch (error) {
                    this.error = error.response.data
                }
            },
            async deleteDegree(degree, index) {
                try {
                    await axios.delete('http://localhost:8000/api/degree/delete/' + degree.id)
                    this.listDegrees.data.splice(index, 1)
                } catch (error) {
                    this.error = error.response.data
                }
            }

        }
    }
</script>


<style lang="scss" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
</style>