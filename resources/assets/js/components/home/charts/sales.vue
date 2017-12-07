<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: ['labels', 'data'],
  mounted () {
      // console.log(this.labels);
    this.renderChart({
      labels: this.labels,
      datasets: [
        {
          label: 'Sales (Euro)',
          backgroundColor: '#41B883',
          data: this.data
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
}
</script>
