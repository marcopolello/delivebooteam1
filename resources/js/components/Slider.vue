<template>

    <div class="card-carousel-wrapper">
        <div class="card-carousel--nav__left" @click="moveCarousel(-1)" :disabled="atHeadOfList"></div>
            <div class="card-carousel">
                <div class="card-carousel--overflow-container">
                    <div class="card-carousel-cards"
                        :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')' }">
                        <div v-for="item in items"
                            :key="item.id">

                            <div class="card-carousel--card">
                                <img :src="item.tag" alt="">
                            </div>

                        <div class="card-carousel--card--footer">
                            <p>{{ item.name }}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-carousel--nav__right"
            @click="moveCarousel(1)"
            :disabled="atEndOfList">
        </div>

        <!-- <button style="width: 50px; padding: 50px;" @click="print()" type="button" name="button">click</button> -->

    </div>




</template>

<script>
    export default {
        data() {
            return {
            currentOffset: 0,
            windowSize: 6,
            paginationFactor: 200,
            items: [
                {name: 'offers', tag: 'storage/img/offers.png'},
                {name: 'organic', tag: 'storage/img/organic.png'},
                {name: 'kebab', tag: 'storage/img/kebab.png'},
                {name: 'burgers', tag: 'storage/img/burgers-1.png'},
                {name: 'dessert', tag: 'storage/img/dessert.png'},
                {name: 'ice-cream', tag: 'storage/img/ice-cream.png'},
                {name: 'pizza', tag: 'storage/img/pizza.png' },
                {name: 'poke', tag: 'storage/img/poke.png'},
                {name: 'sushi', tag: 'storage/img/sushi-1.png'},
            ],
            plate: this.platename,
          }
        },
        computed: {
            atEndOfList() {
            return this.currentOffset <= (this.paginationFactor * -1) * (this.items.length - this.windowSize);
            },
            atHeadOfList() {
            return this.currentOffset === 0;
            },
        },
        methods: {
            moveCarousel(direction) {
              if (direction === 1 && !this.atEndOfList) {
                  this.currentOffset -= this.paginationFactor;
              } else if (direction === -1 && !this.atHeadOfList) {
                  this.currentOffset += this.paginationFactor;
              }
            },
            print() {
              console.log(this.plate);
            }
        },
        props: {
          platename: Array,
        }
    }
</script>
