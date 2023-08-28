<!---->
<script setup>
import { ref } from 'vue'
import CafeComponent from '../components/CafeComponent.vue'

/***/
const { cafes, colors } = defineProps(['cafes', 'colors'])
const roll = (max) => Math.floor(Math.random() * max)
const randomRef = ref(roll(cafes?.length ?? 0))
const onRerollClick = () => void (randomRef.value = roll(cafes?.length ?? 0))
</script>

<!---->
<template>
  <!---->
  <div>
    <div class="inline">
      <h1>Случайное кафе</h1>
      <button class="rerollButton" v-on:click="onRerollClick">⟳</button>
    </div>
    <RouterLink class="undecoratedLink" v-bind:to="(randomRef + 1).toString()">
      <CafeComponent class="pure-u-1 pure-u-md-1-3 pure-u-xl-1-5" v-bind:cafe="cafes?.[randomRef] ?? null" v-bind:color="colors?.[randomRef % colors.length] ?? null" v-bind:key="randomRef" />
    </RouterLink>
  </div>

  <!----><hr />

  <div>
    <h1>Все кафе</h1>
    <RouterLink class="undecoratedLink" v-for="(cafe, i) in cafes" v-bind:to="cafe.id.toString()" v-bind:key="cafe.id">
      <CafeComponent class="pure-u-1 pure-u-md-1-3 pure-u-xl-1-5" v-bind:cafe="cafe" v-bind:color="colors?.[i % colors.length] ?? null" />
    </RouterLink>
  </div>
</template>

<!---->
<style scoped>
.undecoratedLink { /* Make link look like regular text */
  color: unset;
  text-decoration: none;
}

.inline { /* On one line */
  display: flex;
}
.inline > *:not(:last-child) { /* Every child of .inline except the last one gets margin-right */
  margin-right: 16px;
}

.rerollButton {
  font-size: 2rem;
  background-color: transparent;
  border: none;
}
.rerollButton:hover {
  cursor: pointer;
}
</style>
