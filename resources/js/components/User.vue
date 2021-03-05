<template>
   <div class="user-management">
   	<nav class="navbar navbar-default navbar-static-top">
           <div class="container">
               <div class="navbar-header">
                   <!-- Collapsed Hamburger -->
                   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                       <span class="sr-only">Toggle Navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                   </button>

                   <!-- Branding Image -->
                   <a class="navbar-brand" href="/">
                       Laravel
                   </a>
               </div>

               <div class="collapse navbar-collapse" id="app-navbar-collapse">
                   <!-- Left Side Of Navbar -->
                   <ul class="nav navbar-nav">
                       &nbsp;
                   </ul>

                   <!-- Right Side Of Navbar -->
                   <ul class="nav navbar-nav navbar-right">
                           <li class="dropdown">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                   {{ currentUser.name }} <span class="caret"></span>
                               </a>

                               <ul class="dropdown-menu">
                                   <li>
                                       <a href="/logout">Logout</a>
                                   </li>
                               </ul>
                           </li>
                   </ul>
               </div>
           </div>
       </nav>
   </div>
</template>

<script>
   export default {
       data() {
           return {
               currentUser: {}
           }
       },
       created() {
           this.getCurrentUser()
       },
       methods: {
           getCurrentUser() {
               axios.get('/getCurrentUser')
               .then(response => {
                   this.currentUser = response.data
               })
               .catch(error => {
                   console.log(error)
               })
           }
       }
   }
</script>

<style lang="scss" scoped>
</style>