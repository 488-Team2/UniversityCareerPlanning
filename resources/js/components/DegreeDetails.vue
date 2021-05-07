<template>
    <div>
        <a :href="prev_page_url">
            <button id="back" class="btn btn-danger">Back</button>
        </a>

         <!-- <button class="btn btn-danger" onclick="history.go(-1)">Back</button> -->
        <h2 class="mt-3" >{{degree.degree_name}}</h2>
        <p>{{degree.degree_description}}</p>
        <div id="stats">
            <scale class="mb-4" :max='100' :min='0' :rate='parseInt(degree.graduation_rate)' :name="'Graduation Rate'"></scale>
        </div>
        
        <div class="mb-8">
            <h4 class="mt-4" >Job Prospects</h4>
            <li class="mb-2" v-for="job in degree.job_prospects.split(',')" :key="degree.id">
            {{job}}
            </li>
        </div>
         
        <salary  class="mt-4" :jobArr="degree.job_prospects.split(',')"></salary>
        
    </div>
</template>

<script>

import axios from 'axios';

export default {
    props: {
        prev_page_url: {
            type: String,
            required: true
        },
        degree_id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            degree: {
                id: '',
                degree_name: '',
                degree_description: '',
                department_id: '',
                graduation_rate: '',
                job_prospects: '',
            },
            edit: false,
            value: ''
        }
    },

    created() {
        this.fetchDegree();
    },

    methods: {
        async fetchDegree() {
            const id = this.degree_id;

            try{
                const response = await axios.get('/api/degree/' + id);
                this.degree = response.data.data;
            } catch (error) {
                console.error(error);
            }
            
        },
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

#back {
    position: absolute;
    /* right: 2%; */
    right: 120px; 
    top: 70px; 
    text-align: right;

}




</style>
