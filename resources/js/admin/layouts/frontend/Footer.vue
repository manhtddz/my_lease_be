<template>
  <div v-if="!isContactPage">
    <!-- MARK:FOOTER -->
    <div class="fixed" aria-hidden="false" v-if="!isAtBottom">
      <a href="tel:098-989-3889" class="btn is-type1 icon-tel">
        <span class="is-label">Contact us</span>
      </a>
      <a href="/contact" class="btn is-type3 icon-mail">
        <span class="is-label">E-mail</span>
      </a>
    </div>
    <footer class="footer">
      <div class="footer__container">
        <ul class="footer__snslist">
          <li class="footer__snslist--item">
            <a href="https://www.facebook.com/unitedhousing/" target="_blank" class="footer__snslist--link is-facebook">
              <span class="is-accessibility">Official Facebook Page</span>
            </a>
          </li>
        </ul>
        <ul class="footer__navlist">
          <li class="footer__navlist--item"><a href="/policy" class="footer__navlist--link">Privacy Policy</a></li>
          <li class="footer__navlist--item"><a href="/contact" class="footer__navlist--link">Contact</a></li>
        </ul>
        <small class="footer__copyright">© 2025 UnitedHousing All Rights Reserved.</small>
      </div>
    </footer>
    <!-- /FOOTER -->
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { computed, ref, onMounted, onUnmounted } from 'vue'

const route = useRoute()
const isContactPage = computed(() => route.path === '/contact')
const isAtBottom = ref(false)

function checkScroll() {
  const scrollY = window.scrollY || window.pageYOffset
  const windowHeight = window.innerHeight
  const docHeight = Math.max(
    document.body.scrollHeight,
    document.documentElement.scrollHeight,
    document.body.offsetHeight,
    document.documentElement.offsetHeight,
    document.body.clientHeight,
    document.documentElement.clientHeight
  )
  // Nếu trang không đủ dài để scroll, luôn hiện footer
  if (docHeight <= windowHeight + 10) {
    isAtBottom.value = false
    return
  }
  isAtBottom.value = (windowHeight + scrollY) >= (docHeight - 20)
}

onMounted(() => {
  window.addEventListener('scroll', checkScroll, { passive: true })
  window.addEventListener('resize', checkScroll)
  window.addEventListener('orientationchange', checkScroll)
  checkScroll()
})
onUnmounted(() => {
  window.removeEventListener('scroll', checkScroll)
  window.removeEventListener('resize', checkScroll)
  window.removeEventListener('orientationchange', checkScroll)
})
</script>
