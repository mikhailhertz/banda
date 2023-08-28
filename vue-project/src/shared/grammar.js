export function numberInflection(number, one, two, five) { // Склонение в зависимости от числа, копипаст отсюда: https://qna.habr.com/q/546467
  let n = Math.abs(number)
  n %= 100
  if (n >= 5 && n <= 20) {
    return five
  }
  n %= 10
  if (n === 1) {
    return one
  }
  if (n >= 2 && n <= 4) {
    return two
  }
  return five
}
