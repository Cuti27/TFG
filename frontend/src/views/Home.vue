<template>
  <div class="home">
    <section class="intro">
      <div class="intro1">
        <img src="@/assets/Logo.png" alt="Logo de Genhidro" />
        <h2>- Genhidro -</h2>
        <p>
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Neque ipsa
          ratione labore aspernatur, inventore quae esse, aperiam ab dolor sunt
          incidunt deserunt dolores dolorem officia? Officiis corporis sequi
          necessitatibus molestias. Minus eveniet deleniti sed iste inventore et
          libero perspiciatis nostrum illum, voluptate earum illo ad! Aliquam
          natus voluptates, quia reiciendis laborum, id aut perspiciatis ea in
          tempore odit nostrum molestiae! Non, asperiores! Dolor error
          architecto exercitationem libero, totam odit sapiente distinctio qui
          aspernatur. Exercitationem, eligendi aliquid. Laudantium, illo atque
          harum dolorem corporis praesentium molestiae? Eveniet exercitationem
          iusto fugit dolor obcaecati? Vel ex, ipsa magni soluta laborum eum
          minus maxime quidem vitae ad impedit, perspiciatis velit magnam?
          Dolorem consequatur quam magni libero tenetur unde enim dolorum, ex
          iure nulla quis quod.
        </p>
      </div>
      <div class="introImg">
        <img
          src="https://picsum.photos/seed/picsum/1200/1300"
          alt=""
        />
      </div>
    </section>

    <section class="explicacion1">
      <div class="explicacion1Img">
        <img
          src="https://picsum.photos/id/870/200/300?grayscale&blur=2"
          alt=""
        />
      </div>
      <div class="text1">
        <h2>- Programación de riego -</h2>
        <p>
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Neque ipsa
          ratione labore aspernatur, inventore quae esse, aperiam ab dolor sunt
          incidunt deserunt dolores dolorem officia? Officiis corporis sequi
          necessitatibus molestias. Minus eveniet deleniti sed iste inventore et
          libero perspiciatis nostrum illum, voluptate earum illo ad! Aliquam
          natus voluptates, quia reiciendis laborum, id aut perspiciatis ea in
          tempore odit nostrum molestiae! Non, asperiores! Dolor error
          architecto exercitationem libero, totam odit sapiente distinctio qui
          aspernatur. Exercitationem, eligendi aliquid. Laudantium, illo atque
          harum dolorem corporis praesentium molestiae? Eveniet exercitationem
          iusto fugit dolor obcaecati? Vel ex, ipsa magni soluta laborum eum
          minus maxime quidem vitae ad impedit, perspiciatis velit magnam?
          Dolorem consequatur quam magni libero tenetur unde enim dolorum, ex
          iure nulla quis quod.
        </p>
      </div>
    </section>

    <section class="explicacion2">
      <div class="text2">
        <h2>- Fertirrigación -</h2>
        <p>
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rem vel odit
          delectus assumenda consequatur ipsum atque iure sed neque dolor,
          dolorum nesciunt fugiat ab dolores maiores distinctio omnis reiciendis
          quam? Dignissimos maxime, labore laborum nihil consequatur sed culpa!
          Minus dolor expedita ea quibusdam unde illo, autem ipsa blanditiis,
          earum similique in soluta, culpa accusantium nemo voluptates dolores
          repudiandae vero nihil. Quia earum aut inventore, vel dolores
          laboriosam quisquam cum, nobis omnis ea assumenda accusantium, sequi
          tenetur ipsa quas ab minima molestiae! Distinctio laborum explicabo
          eveniet dolorem non facilis, delectus nihil!
        </p>
      </div>
      <div class="explicacion2Img">
        <img
          src="https://picsum.photos/id/870/200/300?grayscale&blur=2"
          alt=""
        />
      </div>
    </section>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.home {
  display: flex;
  flex-direction: column;

  .intro {
    display: flex;
    min-height: 100vh;
    grid-area: intro;
    min-width: 91vw;
    display: flex;
    border: 1px solid;
    background: white;
    margin: 15px 0px;
    border-radius: 5px;

    .intro1 {
      width: 50vw;
      overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;

      img {
        max-height: 33vh;
      }
    }

    .introImg {
      width: 50vw;
      overflow: hidden;
      img {
        max-height: 100vh;
      }
    }
  }

  .explicacion1 {
    display: flex;
    grid-area: exp1;
    height: 50vh;
    width: 93vw;
    border: 1px solid;
    background: white;
    margin: 15px 0px;
    border-radius: 5px;

    .text1{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .explicacion1Img {
      grid-area: exp1Img;
      height: 50vh;
      width: 33vw;
        
      img{
        height: 50vh;
        min-width: 33vw;
      }
    }
  }

  .explicacion2 {
    display: flex;
    grid-area: exp2;
    height: 50vh;
    width: 93vw;
    border: 1px solid;
    background: white;
    margin: 15px 0px;
    border-radius: 5px;

    .text2{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .explicacion2Img {
      grid-area: exp1Img;
      height: 50vh;
      width: 33vw;

      img{
        height: 50vh;
        min-width: 33vw;
      }
    }
  }
}
</style>