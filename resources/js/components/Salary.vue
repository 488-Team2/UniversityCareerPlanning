<template>
    <div>
        <h1>Salary</h1>
    
        <div>
            <select class="mb-4" v-model="currentJobName" name="jobSelect">
                            <option value="0">Please select a job</option>
                            <option v-for="job in jobArr" :value="job">{{ job }}</option>
                         </select>
        </div>
    
        <div>
            <select class="mb-4" v-model="currentState" name="stateSelect">
                            <option value="0">Please select a State</option>
                            <option v-for="state in stateArr" :value="state" >{{ state.state_name}}</option>
                         </select>
        </div>
    
        <div>
            <h2 v-model="formatedSalary" :key="[currentJobCode, currentState.state_code]">{{formatedSalary}}</h2>
        </div>

        <div  v-if="currentJobDemand!=null" id="stats">
            <scale class="mb-4" :max='10' :min='-10' :rate='currentJobDemand' :name="'Job Demand'"></scale>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            jobs: [],
            currentJobName: '',
            currentJobCode: '',
            currentJobDemand: null,
            stateArr: [],
            currentState: {
                state_code: '',
                state_name: ''
            },
            salary: 0,
            formatedSalary: "",
            salaryUpdated: false
        }
    },
    props: {
        jobArr: {
            type: Array,
            required: true
        }
    },

    created() {
        this.fetchStates();
    },

    methods: {
        fetchStates() {

            fetch('/api/states')
                .then(res => res.json())
                .then(res => {
                    this.stateArr = res.data;
                })
                .catch(err => console.log(err));
        },
        async fetchStateJob() {

            await fetch('/api/StateJob/' + this.currentState.state_name + "_" + this.currentJobName)
                .then(res => res.json())
                .then(res => {
                    console.log(res.data.salary)
                    if(typeof res.data.salary !== 'undefined')
                    {
                        this.salary = parseInt(res.data.salary);
                        this.formatedSalary = "$ " + this.salary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        this.salaryUpdated = true;
                    }
                })
                .catch(err => console.log(err));

        },
        async storeStateJob() {
            const response = await axios.post('/api/StateJob/create', {
                state_name: this.currentState.state_name.toString(),
                state_code: this.currentState.state_code.toString(),
                job_name: this.currentJobName.toString(),
                job_code: this.currentJobCode.toString(),
                salary: this.salary
            });
        },
        async calcSalary() {

            this.salaryUpdated = false;

            await this.fetchStateJob();

            if(!this.salaryUpdated){
                console.log("BLS API call");

                const URL = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
                const API_KEY = '?registrationkey=d99cc000b0ef4e9dac845bbb2fb0269d';
                const DATASET = 'OE';
                const NOT_SEASONAL = 'U';
                const STATE = 'S';
                const INDUSTRY_CODE = '000000';
                const AVERAGE_SALARY = '04';              

                var query = URL + DATASET + NOT_SEASONAL + STATE + this.currentState.state_code + INDUSTRY_CODE + this.currentJobCode + AVERAGE_SALARY + API_KEY;
                console.log(query);
                await fetch(query)
                    .then(res => res.json())
                    .then(res => {
                        if(typeof res.Results.series[0].data[0] !== 'undefined' && res.Results.series[0].data[0].value !== "-"){
                            this.salary = parseInt(res.Results.series[0].data[0].value);
                            this.formatedSalary = "$ " + this.salary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            this.storeStateJob();
                        }
                        else
                        {
                            this.formatedSalary = "No Data Available";
                        }
                    })
                    .catch(err => console.log(err));
            }

        }
    },
    watch: {
        'currentJobName': async function() {

        await fetch('/api/job/' + this.currentJobName)
            .then(res => res.json())
            .then(res => {
                this.currentJobCode = res.data.job_code;
                this.currentJobDemand = res.data.demand;
            })
            .catch(err => console.log(err));

            if (this.currentJobCode != '' && this.currentState.state_code != "") {
                this.calcSalary();
            }
        },
        'currentState.state_code': function() {
            if (this.currentJobCode != '' && this.currentState.state_code != "") {
                this.calcSalary();
            }
        }
    },
}
</script>

<style>

#stats {
    padding: 20px;
    border-radius: 25px;
    background-color: #ECECEC;
    width: 50%;
}
</style>