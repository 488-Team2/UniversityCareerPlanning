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
  data() {
        return {
            range: 0,
            midRange: 0
        }
    },
    props: {
        rate: {
            type: Number
        },
        name: {
          type: String
        },
        max: {
          type: Number
        },
        min: {
          type: Number
        }
    },
    created() {
        this.range = (this.max - this.min)
        this.midRange = this.range/2;
    },
    computed: {
    calcRate() {
      
      return {
        "background-color": `#2A2A2A`,
        width: `2%`,
        "margin-left": `${(100/this.range)*this.min*-1+(this.rate*(100/this.range))}%` 

      };
    },
    calcLocation() {
      return {
        "margin-left": `${(100/this.range)*this.min*-1+(this.rate*(100/this.range))}%`

      };
    }
  }
}
</script>

<style>



/* Container for skill bars */
#container {
  width: 100%; /* Full width */
  background-image: linear-gradient(to right, red, yellow, green);
  border-radius: 25px;
}



.skills {
  text-align: right; /* Right-align text */
  padding-top: 10px; /* Add top padding */
  padding-bottom: 10px; /* Add bottom padding */
  color: white; /* White text color */
}
</style>