<template>

    <div class="card-carousel-wrapper">
        <div class="card-carousel--nav__left" @click="moveCarousel(-1)" :disabled="atHeadOfList"></div>
            <div class="card-carousel">
                <div class="card-carousel--overflow-container">
                    <div class="card-carousel-cards"
                        :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')' }">
                        <div v-for="item in items"
                            :key="item.id">

                            <div class="card-carousel--card" 
                                @click='$root.startResearchSlider(item.link)'>
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
                {link: '', name: 'Offers', tag: 'storage/img/offers.png'},
                {link: 'italiano', name: 'Italiano', tag: 'storage/img/organic.png'},
                {link: 'kebab', name: 'Kebab', tag: 'storage/img/kebab.png'},
                {link: 'burger', name: 'Burgers', tag: 'storage/img/burgers-1.png'},
                {link: 'dessert', name: 'Dessert', tag: 'storage/img/dessert.png'},
                {link: 'frappe', name: 'Frappè', tag: 'storage/img/ice-cream.png'},
                {link: 'pizza', name: 'Pizza', tag: 'storage/img/pizza.png' },
                {link: 'poke', name: 'Pokè', tag: 'storage/img/poke.png'},
                {link: 'sushi', name: 'Sushi', tag: 'storage/img/sushi-1.png'},
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
            },
        },
        props: {
          platename: Array,
        }
    }
</script>
