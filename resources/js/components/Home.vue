<template>
    <div>     
        <h1 class="text-center">  University Career Planning </h1>
        <p class="text-md-center">
        Explore our undergraduate, master's, doctoral, and certificate programs.
        Search your interests and we will match you with degrees
        </p>
        <div class="input-group mb-3">
            <input v-model="keywords" class="form-control mr-sm-2" placeholder="career or degree keywords">
            <a :href="'/degreeSearch/' + this.keywords">
                <button class="btn btn-outline-secondary my-2 my-sm-0" @ >Search</button>
            </a>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-outline-danger">SEARCH BY INTERESTS</button>
            <button type="button" class="btn btn-outline-danger">   TAKE SERVEY   </button>
        </div>
        <br> 
        <h3 class="text-center">All available programs</h3>
        <div class="d-flex justify-content-center">

            <ul class="list-inline">
            <li class="list-inline-item">UNDERGRADUATE</li>
            <li class="list-inline-item">GRADUATE</li>
            <li class="list-inline-item">MINORS</li>
            </ul>
        </div>
    </div>

</template>    

<script>
    export default {
        data: function () {
            return {
                keywords: ""
            }
        },
    }

</script>
<style >
nav {
    background-color: darkgray;
}
.nav-link {
    color: #fff;
}
</style>
