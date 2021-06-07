<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <div class="container">
            <div class="navbar-header">
                <a id="header" class="navbar=brand" href="/">University Career Planning</a>
            </div>
            <div class="row">
                <div class="col">

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="https://www.ewu.edu/">EWU Official Website</a></li>
                        <li class="nav-item"><a class="nav-link" href="/contact">Contact Us</a></li>

                        <li class="nav-item"><a class="nav-link" href="/degrees">Degrees</a></li>
                        <li class="nav-item"><a class="nav-link" href="/survey">Career Survey</a></li>
                        <li class="nav-item"><a class="nav-link" >|</a></li>
                        <li class="nav-item" v-if="currentUser == null"><a class="nav-link" href="/register">Register</a></li>
                        <li class="nav-item" v-if="checkIsAdmin">
                            <a class="nav-link"
                               href="/admin/dashboard">{{ (currentUser !== null) ? currentUser.name : "Dashboard" }}</a>
                        </li>
                        <li class="nav-item" v-else-if="currentUser !== null">
                            <a class="nav-link"
                               href="/student/dashboard">{{ (currentUser !== null) ? currentUser.name : "Dashboard" }} </a>
                        </li>
                        <li class="nav-item" v-if="currentUser !== null"><a class="nav-link" >-</a></li>
                        <li class="nav-item" v-if="currentUser !== null"><a class="nav-link" href="/logout">Logout</a></li>
                        <li class="nav-item" v-else><a class="nav-link" href="/login">Login</a></li>

                        
                    </ul>
                </div>
            </div>
        </div>
    </nav>

</template>

<script>
export default {
    name: "navbar",
    data() {
        return {
            currentUser: null
        }
    },
    async created() {
        await this.getCurrentUser()
    },
    methods: {
        async getCurrentUser() {
            axios.get('/getCurrentUser')
                .then(response => {
                    this.currentUser = response.data
                })
                .catch(error => {
                    this.currentUser = null;
                    console.log(error)
                })
        },
    },
    computed: {
        checkIsAdmin() {
            if (this.currentUser !== null && this.currentUser.roles) {
                let check = false
                this.currentUser.roles.forEach(role => {
                    if (role.name === 'admin') {
                        check = true
                    }
                })
                return check
            }
        }
    }
}
</script>

<style>
  nav{
         display: flex;
        flex-wrap: wrap;
         background-color: #990000;
  }  

  nav li:hover{
     background-color: #990000;
     transform: translateY(-10px);
  } 
  nav li:active{
      background-color: #990000;
  }

</style>
