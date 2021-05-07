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
            <scale class="mb-4" :max='10' :min='-10' :rate='parseFloat(currentJobDemand)' :name="'Job Demand'"></scale>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import fetch from 'cross-fetch'

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
        async fetchStates() {

            try{
                const response = await axios.get('/api/states');
                this.stateArr = response.data.data;
            } catch (error) {
                console.error(error);
            }
            
        },
        async fetchStateJob() {

            try{
                const response = await axios.get('/api/StateJob/' + this.currentState.state_name + "_" + this.currentJobName);
                if(typeof response.data.data.salary !== 'undefined')
                {
                    this.salary = parseInt(response.data.data.salary);
                    this.formatedSalary = "$ " + this.salary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.salaryUpdated = true;
                }
            } catch (error) {
                console.error(error);
            }

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

                const URL = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
                const API_KEY = '?registrationkey=d99cc000b0ef4e9dac845bbb2fb0269d';
                const DATASET = 'OE';
                const NOT_SEASONAL = 'U';
                const STATE = 'S';
                const INDUSTRY_CODE = '000000';
                const AVERAGE_SALARY = '04';  // 03 -> average hourly rate

                var query = URL + DATASET + NOT_SEASONAL + STATE + this.currentState.state_code + INDUSTRY_CODE + this.currentJobCode + AVERAGE_SALARY + API_KEY;
                
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

            try{
                const response = await axios.get('/api/job/' + this.currentJobName);
                this.currentJobCode = response.data.data.job_code;
                this.currentJobDemand = response.data.data.demand;
            } catch (error) {
                console.error(error);
            }

            if (this.currentJobCode != '' && this.currentState.state_code != "") {
                await this.calcSalary();
            }
        },
        'currentState.state_code': async function() {
            if (this.currentJobCode != '' && this.currentState != "") {
                await this.calcSalary();
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