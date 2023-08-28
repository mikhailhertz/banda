<!---->
<script setup>
import { ref } from 'vue'
import { RouterView } from 'vue-router'

/***/
const cafesRef = ref(null)
const colorsRef = ref(null)

/***/
const stringValidator = (string) => (string.length > 0 ? string : null) // Zero length string becomes null

const blobGetter = async (string) => { // If string is a valid url, get the blob
  try {
    return await (await fetch(new URL(string))).blob()
  } catch {
    return null
  }
}

const cafeFormatter = async (element) => { // Validates strings and loads the photo
  const blob = await blobGetter(element.photo)
  if (blob && blob.type.startsWith('image')) {
    element.photo = URL.createObjectURL(blob)
  }
  element.name = stringValidator(element.name)
  element.address = stringValidator(element.name)
  element.landmark = stringValidator(element.name)
  element.cuisine = stringValidator(element.name)
}

/***/
;(async () => { // Gets cafes and cafe-themed colors, saves them to the ref
  /***/
  const cafes = await (await fetch('https://bandaumnikov.ru/api/test/site/get-index')).json()
  const colors = await (await fetch('https://www.colr.org/json/tags/cafe')).json()

  /***/
  cafes.data.forEach(cafeFormatter)
  cafesRef.value = cafes.data.map((element) => {
    return {
      ...element
    }
  })

  /***/
  colorsRef.value = colors.colors.map((element) => '#' + element.hex)
})()
</script>

<!---->
<template>
  <div class="appContainer">
    <RouterView v-if="cafesRef" v-bind:cafes="cafesRef" v-bind:colors="colorsRef" />
  </div>
</template>

<!---->
<style> /* Global styles */
@import 'https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css'; /* Pure.css */
@import 'https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/grids-responsive-min.css'; /* Pure.css grids */

hr { /* Separator */
  border-width: 0;
  border-top: 1px solid rgb(255, 255, 255);
}

.appContainer {
  padding: 6px;
}
</style>
