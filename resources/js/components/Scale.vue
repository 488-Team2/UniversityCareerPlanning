<template>
    <div>
        <h5>{{name}}</h5>
        <div :style="calcLocation">{{rate}}%</div>
        <div id="container">
            
            <div class="skills" :style="calcRate" ></div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        rate: {
            type: String
        },
        name: {
          type: String
        }

    },
    computed: {
    calcRate() {
      return {
        "background-color": `#2A2A2A`,
        width: `2%`,
        "margin-left": `${100-parseInt(this.rate)}%`

      };
    },
    calcLocation() {
      return {
        "margin-left": `${(100-parseInt(this.rate))}%`

      };
    }
  }
}
</script>

<style>



/* Container for skill bars */
#container {
  width: 100%; /* Full width */
  background-image: linear-gradient(to right, green, yellow, red);
  border-radius: 25px;
}



.skills {
  text-align: right; /* Right-align text */
  padding-top: 10px; /* Add top padding */
  padding-bottom: 10px; /* Add bottom padding */
  color: white; /* White text color */
}
</style>