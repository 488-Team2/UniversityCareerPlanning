<template>
    <div class="api-degree container mt-5">
        <button id="back-btn" class="btn btn-danger" onclick="history.back()">Back</button>
        <br><br>
        <transition name="fade">
            <div id="errors" class="alert alert-danger alert-dismissible" role="alert" v-if="error">
                <b>{{ error.message }}</b>
                <ul>
                    <li v-for="(errorName, index) in error.errors" :key="index">
                        {{ errorName[0] }}
                    </li>
                </ul>
                <button type="button" class="btn btn-light" @click="error = null">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </transition>
        <div class="gridContainer">
            <div id="degreeForm">
                <div>
                    <h1 v-if="!degree.isEdit">Create Degree</h1>
                    <h1 v-else>Update Degree</h1>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" v-model="degree.degree_name" placeholder="Name...">
                </div><br />
                <div class="form-group">
                    <label>Degree Type</label>
                    <input class="form-control" v-model="degree.degree_type" rows="5" placeholder="Degree Type..."></input>
                </div><br />
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" v-model="degree.degree_description" rows="5" placeholder="Description..."></textarea>
                </div><br />
                <div class="form-group">
                    <div class="inline">
                        <label>Category (select up to three. To learn more about the categories click</label>
                        <a href="https://www.thecareerproject.org/blog/how-are-you-intelligent-an-introduction-to-the-holland-codes-riasec/">here</a>
                        <label>)</label>
                    </div>
                    <li class="mb-1"  v-for="(item, key, index) in degree_codes" :key="index">
                        <label>
                            <input type="checkbox" 
                                :id='key' 
                                :value='key' 
                                v-model="checkedCategories" 
                                :disabled="checkedCategories.length > 2 && checkedCategories.indexOf(key) === -1" >
                                {{item}}
                        </label>
                    </li>
                    <br>
                </div>
    
                <div class="form-group">
                    <label>Department Id</label>
                    <input type="text" class="form-control" v-model="degree.department_id" placeholder="id...">
                </div><br />
                <div class="form-group">
                    <label>Graduation Rate</label>
                    <input type="text" class="form-control" v-model="degree.graduation_rate" placeholder="rate...">
                </div><br />
    
                <div>
                    <label>Job Prospects</label>
                    <div id="selectedJobs">
                        <li class="mb-1" v-for="(job, index) in selectedJobNames" :key="index">
                            <button id="delete" type="button" class="btn btn-danger" @click="removeJob(job)">Delete</button> {{job}}
                        </li>
                    </div>
                </div>
    
                <div>
                    <select id="dropDown" class="mb-4" v-model="selectedJob" name="jobSelect" @change="addJob">
                            <option value="0">Please select a job</option>
                            <option v-for="job in jobArr" :value="job.job_name">{{ job.job_name }}</option>
                        </select>
                </div>
    
                <div>
                    <button v-if="!degree.isEdit" class="btn btn-primary" @click="createDegree">Create</button>
                    <div v-else>
                        <button class="btn btn-primary" @click="updateDegree">Update</button>
                        <button class="btn btn-danger" @click="clearForm">Cancel</button>
                    </div>
                </div>
            </div>
    
            <div id="degreeList">
                <h1>List Degrees</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Grad Rate</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <transition-group name="slide-fade" tag="tbody">
                        <tr v-for="(degree, index) in listDegrees.data" :key="degree.id">
                            <th scope="row"> {{ degree.degree_name }} </th>
    
                            <td>{{ degree.degree_type}}</td>
    
                            <td v-if="degree.degree_description.length<120"> {{ degree.degree_description }} </td>
                            <td v-else> {{degree.degree_description.substring(0,120)+"..."}} </td>
    
                            <td>{{ degree.graduation_rate }}</td>
    
                            <td v-if="!degree.isEdit">
                                <button id="item" class="btn btn-primary" @click="selectDegree(degree, index)">Edit</button>
                                <button id="item" class="btn btn-danger" @click="deleteDegree(degree, index)">Delete</button>
                            </td>
                            <td class="item" v-else>
                                <button id="item" class="btn btn-primary" @click="updateDegree()">Save</button>
                                <button id="item" class="btn btn-danger" @click="clearForm()">Cancel</button>
                            </td>
                        </tr>
                    </transition-group>
                </table>
    
                <div>
                    {{ listDegrees.from }} - {{ listDegrees.to }} of {{ listDegrees.total }}
                </div>
                <ul class="pagination">
                    <li class="page-item" :class="{ 'disabled': listDegrees.prev_page_url === null }" @click="listDegrees.prev_page_url && getListDegrees(listDegrees.current_page - 1)">
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
                    <li class="page-item" :class="{ 'disabled': listDegrees.next_page_url === null }" @click="listDegrees.next_page_url && getListDegrees(listDegrees.current_page + 1)">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            degree: {
                id: '',
                degree_name: '',
                degree_type: '',
                degree_description: '',
                degree_code: '',
                department_id: '',
                graduation_rate: 0,
                job_prospects: '',
            },
            index: 0,
            listDegrees: {},
            error: null,
            jobArr: [],
            selectedJob: "",
            selectedJobNames: [],
            checkedCategories: [],
            degree_codes: {
                "R": "Realistic: Doers",
                "I": "Investigative: Thinkers",
                "A": "Artistic: Creators",
                "S": "Social: Helpers",
                "E": "Enterprising: persuaders",
                "C": "Conventional: Organizers"
            }
        }
    },
    created() {
        this.getListDegrees();
        this.fetchJobs();
    },
    methods: {
        addJob() {
            if (this.selectedJob !== "0")
                this.selectedJobNames.push(this.selectedJob);
        },
        removeJob(job) {
            const index = this.selectedJobNames.indexOf(job);
            if (index > -1) {
                this.selectedJobNames.splice(index, 1);
            }
        },
        fetchJobs() {
            fetch('/api/jobs')
                .then(res => res.json())
                .then(res => {
                    this.jobArr = res.data;
                })
                .catch(err => console.log(err));
        },
        async createDegree() {
            try {
                this.error = null
                const response = await axios.post('/api/degree/create', {
                    degree_name: this.degree.degree_name,
                    degree_type: this.degree.degree_type,
                    degree_description: this.degree.degree_description,
                    degree_code: this.checkedCategories.join(''),
                    department_id: this.degree.department_id,
                    graduation_rate: this.degree.graduation_rate,
                    job_prospects: this.selectedJobNames.join()
                });

                this.listDegrees.data.unshift({
                    ...response.data.degree,
                    isEdit: false
                })


                this.clearForm();

            } catch (error) {
                this.error = error.response.data
            }


        },
        async getListDegrees(page = 1) {
            try {
                const response = await axios.get('/api/degreeDisplay?page=' + page)
                this.listDegrees = response.data
                this.listDegrees.data.forEach(item => {
                    Vue.set(item, 'isEdit', false)
                })
            } catch (error) {
                this.error = error.response.data
            }
        },
        selectDegree(degree, index) {

            window.scrollTo(0, 0);

            degree.isEdit = true
            this.index = index
            this.degree = { ...degree }
            this.selectedJobNames = degree.job_prospects.split(',');
            if (degree.degree_code != null) {
                this.checkedCategories = degree.degree_code.split('');
            }

        },
        async updateDegree() {
            try {
                this.error = null;
                console.log('api/degree/update/' + this.degree.id);
                const response = await axios.put('api/degree/update/' + this.degree.id, {
                    degree_name: this.degree.degree_name,
                    degree_type: this.degree.degree_type,
                    degree_description: this.degree.degree_description,
                    degree_code: this.checkedCategories.join(''),
                    department_id: this.degree.department_id,
                    graduation_rate: this.degree.graduation_rate,
                    job_prospects: this.selectedJobNames.join()
                })

                this.listDegrees.data[this.index].degree_name = response.data.degree.degree_name
                this.listDegrees.data[this.index].degree_type = response.data.degree.degree_type
                this.listDegrees.data[this.index].degree_description = response.data.degree.degree_description
                this.listDegrees.data[this.index].degree_code = response.data.degree.degree_code
                this.listDegrees.data[this.index].department_id = response.data.degree.department_id
                this.listDegrees.data[this.index].graduation_rate = response.data.degree.graduation_rate
                this.listDegrees.data[this.index].job_prospects = response.data.degree.job_prospects
                this.listDegrees.data[this.index].isEdit = false

                this.clearForm();

            } catch (error) {
                this.error = error.response.data
            }



        },
        clearForm() {
            //reset form to initial
            this.degree = {
                id: '',
                degree_name: '',
                degree_type: '',
                degree_description: '',
                degree_code: '',
                department_id: '',
                graduation_rate: 0,
            }
            this.selectedJobNames = [];
            this.checkedCategories = [];
            this.listDegrees.data[this.index].isEdit = false;
        },
        async deleteDegree(degree, index) {
            try {
                await axios.delete('/api/degree/delete/' + degree.id)
                this.listDegrees.data.splice(index, 1)
            } catch (error) {
                this.error = error.response.data
            }
        }
    }
}
</script>


<style lang="scss" scoped>
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
    transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}

#delete {
    font-size: 80%;
    padding: .3%
}

#selectedJobs {
    padding: 20px;
    border: 1px solid #d4d4d4;
    border-radius: 5px;
    background: white;
}

li {
    list-style-type: none;
}

#errors {
    position: fixed;
}

.inline {
    display: inline;
}

#dropDown {
    width: 100%;
}

#degreeList {}

#degreeForm {}

.gridContainer {
    margin-top: 1%;
    display: grid;
    width: 100%;
    grid-template-columns: 50% 50%;
    grid-gap: 3%
}

@media (max-width: 1100px) {
    .gridContainer {
        grid-template-columns: 100%;
    }
}

#box {
    display: flex;
    margin: 45px;
    padding: 45px;
}

#item {
    margin: 10%;
}
</style>