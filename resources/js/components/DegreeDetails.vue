<template>
    <div>
       <h2 class="mt-3">{{degree.degree_name}}</h2>
       <p>{{degree.degree_description}}</p>
       <div id="stats">
        <scale class="mb-4" :rate='degree.graduation_rate' :name="'Graduation Rate'"></scale>
        <scale class="mb-4" :rate='degree.job_demand' :name="'Job Demand'"></scale>
       </div>

       <div>
       
       </div>
    </div>
</template>

<script>

export default{
    data() {
        return {
            degree: {
                id: '',
                degree_name: '',
                degree_description: '',
                department_id: '',
                graduation_rate: '',
                job_demand: ''
            },
            edit: false,
            value: ''
        }
    },

    created() {
        this.fetchDegree();
        this.calcSalary();
    },

    methods: {
        fetchDegree() {
            const url = window.location.href;
            const id = url.split("/").slice(-1)[0]; // gets the id from the url

            fetch('/api/degree/' + id)
                .then(res => res.json())
                .then(res => {
                    this.degree = res.data;
                })
                .catch(err => console.log(err));
        },
        calcSalary() {
            const URL = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
            const API_KEY = '?key=d99cc000b0ef4e9dac845bbb2fb0269d';
            const DATASET = 'OE';
            const NOT_SEASONAL = 'U';
            const STATE = 'S';
            const INDUSTRY_CODE = '000000';
            const AVERAGE_SALARY = '04';

            var stateCode = '5300000';
            var occupationalCode = '172071';

            var query = URL + DATASET + NOT_SEASONAL + STATE + stateCode + INDUSTRY_CODE + occupationalCode + AVERAGE_SALARY + API_KEY;
            var value;
            fetch(query)
                .then(res => res.json())
                .then(res => {
                    this.value = res.Results.series[0].data[0].value;
                })
                .catch(err => console.log(err));


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
