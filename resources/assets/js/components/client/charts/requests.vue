<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  props: ['data'],
  mounted () {
  console.log(this.data);
    this.renderChart({
      labels: ['In progress', 'Done', 'Canceled'],
      datasets: [
        {
          backgroundColor: [
              '#00D8FF',
            '#41B883',
            '#E46651',

            // '#cc65fe'
            // '#DD1B16'
          ],
          data: this.data,
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
}
</script>
