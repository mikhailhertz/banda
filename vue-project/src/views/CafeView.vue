<!---->
<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import CafeComponent from '../components/CafeComponent.vue'

const { cafes, colors } = defineProps(['cafes', 'colors'])
const route = useRoute()
const textRef = ref('')
const commentsRef = ref([])
const onSubmitComment = async (e) => {
  e.preventDefault()
  const comment = textRef.value
  textRef.value = ''
  const request = new FormData()
  request.append('text', comment)
  request.append('cafe_id', route.params.id)
  const response = await (await fetch('/index.php?r=site%2Fcomment', {
    method: 'POST',
    body: request
  })).json()
  if (response.code === 200) {
    commentsRef.value.push({
      text: response.comment
    })
  }
}

;(async () => {
  const request = new FormData()
  request.append('cafe_id', route.params.id)
  const comments = await (await fetch('/index.php?r=site%2Fget-comments', {
    method: 'POST',
    body: request
  })).json()
  commentsRef.value = comments.comments;
})()
</script>

<!---->
<template>
  <div v-if="cafes?.[route.params.id - 1]">
    <div class="cafeViewOuter">
      <div class="cafeViewInner">
        <CafeComponent v-bind:cafe="cafes?.[route.params.id - 1] ?? null" v-bind:color="colors?.[(parseInt(route.params.id) - 1) % colors.length]" v-bind:big="true" />
        <form v-on:submit="onSubmitComment">
          <textarea class="uglyTextarea" v-model="textRef" placeholder="Комментарий"></textarea>
          <input type="submit" value="Отправить" />
        </form>
        <p v-for="(comment, i) in commentsRef" v-bind:key="i">
        {{ comment.text }}
        </p>
      </div>
    </div>
  </div>
  <div v-else>404</div>
</template>

<!---->
<style scoped>
.uglyTextarea {
  width: 100%;
  height: 4rem;
  box-sizing: border-box;
}

.cafeViewOuter {
  display: flex;
  justify-content: center;
  width: 100%;
}

.cafeViewInner {
  width: 60%;
}
</style>
