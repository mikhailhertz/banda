<!---->
<script setup>
import { numberInflection } from '../shared/grammar'

const { cafe, color, big } = defineProps(['cafe', 'color', 'big'])
</script>

<!---->
<template>
  <div v-if="cafe" class="cafeComponentContainer">
    <!---->
    <div v-bind:class="big ? 'titleCard big' : 'titleCard'">
      <img v-if="cafe.photo" class="cafeComponentImage" v-bind:src="cafe.photo" />
      <div v-else class="cafeComponentImagePlaceholder" :style="{ backgroundColor: color ?? '#000' }"></div>
      <div class="gradientOverlay"></div>
      <h2>{{ cafe.name }}</h2>
    </div>

    <!---->
    <p v-if="cafe.cuisine">{{ `Кухня: ${cafe.cuisine}` }}</p>
    <p>{{ `Бизнес-ланч: ${cafe.business_lunch ? 'да' : 'нет'}` }}</p>
    <p>{{ `Средний чек: ${cafe.price} ${numberInflection(cafe.price, 'рубль', 'рубля', 'рублей')}` }}</p>

    <!----><hr />

    <p v-if="cafe.address">{{ cafe.address }}</p>
    <p>{{ `Расстояние от метро: ${cafe.distance} ${numberInflection(cafe.distance, 'метр', 'метра', 'метров')}, пешком ~${cafe.time} ${numberInflection(cafe.time, 'минута', 'минуты', 'минут')}` }}</p>
    <p v-if="cafe.landmark">{{ cafe.landmark }}</p>
  </div>
</template>

<!---->
<style scoped>
.cafeComponentContainer {
  padding: 6px;
  box-sizing: border-box;
}

.cafeComponentImage {
  height: 100%;
  width: 100%;
  object-position: center;
  object-fit: cover;
  display: block;
}
.cafeComponentImagePlaceholder {
  height: 100%;
  width: 100%;
}


.titleCard {
  height: 300px;
  position: relative;
}
.big {
  height: 600px;
}
.gradientOverlay {
  position: absolute;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgb(0, 0, 0);
  background: linear-gradient(180deg, rgba(0, 0, 0, 0) 67%, rgba(0, 0, 0, 0.2539390756302521) 84%, rgba(0, 0, 0, 0.80015756302521) 100%);
}
.titleCard > h2 {
  position: absolute;
  bottom: 0;
  margin-left: 8px;
  color: white;
}
</style>
