<template>
    <div>
        <h1>Salary</h1>
    
        <div>
            <select class="mb-4" v-model="currentJob" name="jobSelect">
                            <option value="0">Please select a job</option>
                            <option v-for="job in jobArr" @click="fetchJobCode()" :value="job">{{ job }}</option>
                         </select>
        </div>
    
        <div>
            <select class="mb-4" v-model="currentState" name="stateSelect">
                            <option value="0">Please select a State</option>
                            <option v-for="state in stateArr" :value="state" >{{ state.state_name}}</option>
                         </select>
        </div>
    
        <div>
            <h2 v-model="salary" :key="[currentJob, currentState]">{{salary}}</h2>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            jobs: [],
            currentJob: '',
            currentJobCode: '',
            stateArr: [],
            currentState: null,
            salary: '',
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
        calcSalary() {

            console.log("calcSalary");

            const URL = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
            const API_KEY = '?registrationkey=d99cc000b0ef4e9dac845bbb2fb0269d';
            const DATASET = 'OE';
            const NOT_SEASONAL = 'U';
            const STATE = 'S';
            const INDUSTRY_CODE = '000000';
            const AVERAGE_SALARY = '04';

            var query = URL + DATASET + NOT_SEASONAL + STATE + this.currentState.state_code + INDUSTRY_CODE + this.currentJobCode + AVERAGE_SALARY + API_KEY;
            console.log(query);
            fetch(query)
                .then(res => res.json())
                .then(res => {
                    this.salary = typeof res.Results.series[0].data[0] !== 'undefined' ? "$ " + res.Results.series[0].data[0].value.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : "no data available";
                })
                .catch(err => console.log(err));

        } //some states don't track all jobs like "Software and Web Developers Programmers and Testers"
    },
    watch: {
        'currentJobCode': function() {
            if (this.currentJobCode != '' && this.currentState != null) {
                this.calcSalary();
            }
        },
        'currentState': function() {
            if (this.currentJobCode != '' && this.currentState != null) {
                this.calcSalary();
            }
        }
    },
    computed: {
        fetchJobCode() {
            console.log(this.currentJob);
            fetch('/api/job/' + this.currentJob)
                .then(res => res.json())
                .then(res => {
                    this.currentJobCode = res.data.job_code;
                })
                .catch(err => console.log(err));

        },
    }

}
</script>

<style>

</style>