<template>
  <grid :cols="cols" :rows="rows"></grid>
</template>

<script>
import axios from '../axios'
import Grid from 'gridjs-vue'

export default {
  name: 'Wallet',
  components: {
    Grid
  },
  data () {
    return {
      cols: [
        'Wallet code',
        'Currency wallet',
        'Tag',
        'Total amount booked',
        'Total amount available',
        'Date last movement',
      ],
      rows: []
    }
  },
  created() {
    axios.get('/wallets')
        .then(request => this.formatApiResponse(request))
        .catch(() => this.$router.push('/'))
  },
  methods: {
    formatApiResponse (request) {
      const wallets = request.data.wallets
      let output = []
      wallets.map(wallet => {
        output.push([
          wallet.id,
          wallet.currency,
          wallet.tag,
          `${wallet.bookingAmount.value} ${wallet.bookingAmount.currency}`,
          `${wallet.valueAmount.value} ${wallet.valueAmount.currency}`,
          wallet.dateLastFinancialMovement
        ])
      })

        this.rows = output

      return true
    }
  }
}
</script>

<style lang="css">
body {
  background: #605B56;
}

.login-wrapper {
  background: #fff;
  width: 70%;
  margin: 12% auto;
}

.form-signin {
  max-width: 330px;
  padding: 10% 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="username"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>