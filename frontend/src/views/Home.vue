<template>
  <div class="home">
    <section class="banner">
      <div class="content">
        <h1>Genhidro</h1>
        <p class="major">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente unde
          adipisci perspiciatis hic, et tempore rem magnam ut, distinctio
          dolorum reprehenderit autem, consectetur eaque corporis voluptas
          minima eius magni temporibus! Corporis qui quidem alias dignissimos.
          Voluptatum odio possimus quia. Qui minima harum distinctio voluptatem
          laborum, quae suscipit quisquam perferendis obcaecati repellendus
          cumque nesciunt, ea facere, blanditiis animi ex enim. Quas. Quis amet,
          vitae iure in nobis laboriosam magni, mollitia officiis provident
          atque quibusdam aliquid quod quo aut eveniet repellendus harum iste
          fugiat eligendi quisquam. Ab harum quaerat aperiam eum adipisci!
        </p>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio
          dolores officiis corporis recusandae! Vel eaque, consequuntur nihil
          magnam enim quia unde tempora maiores iusto! Illum numquam nostrum vel
          voluptate ipsa?
        </p>
      </div>
      <div class="image">
        <img class="logo" src="../assets/Logo.png" alt="" />
        <img src="../assets/Home1.jpg" alt="" />
      </div>
    </section>

    <section class="section1 reverse">
      <div class="content">
        <h2>Programación Riego</h2>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio
          dolores officiis corporis recusandae! Vel eaque, consequuntur nihil
          magnam enim quia unde tempora maiores iusto! Illum numquam nostrum vel
          voluptate ipsa?
        </p>
      </div>
      <div class="image">
        <img src="../assets/Home2.jpg" alt="" />
      </div>
    </section>

    <section class="section1">
      <div class="content">
        <h2>Fertirrigación</h2>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio
          dolores officiis corporis recusandae! Vel eaque, consequuntur nihil
          magnam enim quia unde tempora maiores iusto! Illum numquam nostrum vel
          voluptate ipsa?
        </p>
      </div>
      <div class="image">
        <img src="../assets/Home2.jpg" alt="" />
      </div>
    </section>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.home {
  section {
    box-shadow: inset 0 1px 0 0 rgba(0, 0, 0, 0.075);
  }

  p {
    margin: 0 0 2rem 0;
  }

  .image {
    border: 0;
    border-radius: 4px;
    display: inline-block;
    position: relative;
  }

  h1 {
    font-size: 3.5rem;
    line-height: 1.2;
  }

  h2 {
    font-size: 2.25rem;
  }

  .banner {
    box-shadow: none !important;
    min-height: 100vh;
    align-items: stretch;
    display: flex;
    justify-content: flex-end;
    position: relative;
    text-align: left;
    overflow-x: hidden;
    margin: 0;
    padding: 0;
    border: 0;
    text-align: left;

    .content {
      padding: 7rem 7rem 5rem 7rem;
      -moz-align-self: center;
      -webkit-align-self: center;
      -ms-align-self: center;
      align-self: center;
      -moz-flex-grow: 1;
      -webkit-flex-grow: 1;
      -ms-flex-grow: 1;
      flex-grow: 1;
      -moz-flex-shrink: 1;
      -webkit-flex-shrink: 1;
      -ms-flex-shrink: 1;
      flex-shrink: 1;
      width: 50%;
      max-width: 48rem;
      margin: 0 auto;
      border-radius: 76px 0px 0px 76px;
      background: #f6f6f6;
      box-shadow: 41px 21px 82px #c5c4c4, -41px -41px 82px $base;
    }

    p.major {
      font-size: 1.25rem;
    }

    .image {
      -moz-flex-grow: 0;
      -webkit-flex-grow: 0;
      -ms-flex-grow: 0;
      flex-grow: 0;
      -moz-flex-shrink: 0;
      -webkit-flex-shrink: 0;
      -ms-flex-shrink: 0;
      flex-shrink: 0;
      border-radius: 0;
      width: 50%;
      background-color: rgba(0, 0, 0, 0.125);
      border: 0;
      border-radius: 4px;
      display: inline-block;
      position: relative;
      img {
        -moz-object-position: right;
        -webkit-object-position: right;
        -ms-object-position: right;
        object-position: right;
        -moz-object-fit: cover;
        -webkit-object-fit: cover;
        -ms-object-fit: cover;
        object-fit: cover;
        -moz-object-position: center;
        -webkit-object-position: center;
        -ms-object-position: center;
        object-position: center;
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
      }

      .logo {
        -moz-object-position: right;
        -webkit-object-position: right;
        -ms-object-position: right;
        object-position: right;
        -moz-object-fit: cover;
        -webkit-object-fit: cover;
        -ms-object-fit: cover;
        object-fit: cover;
        -moz-object-position: center;
        -webkit-object-position: center;
        -ms-object-position: center;
        object-position: center;
        display: block;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: auto;
        border-radius: 25px;
        padding: 40px;
        z-index: 9990;
        background: rgba(255, 255, 255, 0.9);
      }
    }
  }

  .section1 {
    -moz-align-items: -moz-stretch;
    -webkit-align-items: -webkit-stretch;
    -ms-align-items: -ms-stretch;
    align-items: stretch;
    display: -moz-flex;
    display: -webkit-flex;
    display: -ms-flex;
    display: flex;
    -moz-flex-direction: row;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    -moz-justify-content: -moz-flex-end;
    -webkit-justify-content: -webkit-flex-end;
    -ms-justify-content: -ms-flex-end;
    justify-content: flex-end;
    position: relative;
    overflow-x: hidden;
    text-align: left;
    min-height: 50vh;

    .content {
      padding: 7rem 7rem 5rem 7rem;
      -moz-align-self: center;
      -webkit-align-self: center;
      -ms-align-self: center;
      align-self: center;
      -moz-flex-grow: 1;
      -webkit-flex-grow: 1;
      -ms-flex-grow: 1;
      flex-grow: 1;
      -moz-flex-shrink: 1;
      -webkit-flex-shrink: 1;
      -ms-flex-shrink: 1;
      flex-shrink: 1;
      width: 65%;
      max-width: 64rem;
      margin: 0 auto;
      border-radius: 76px 0px 0px 76px;
      background: #f6f6f6;
      box-shadow: 41px 21px 82px $primaryDark, -41px -41px 82px $base;
    }

    .image {
      -moz-flex-grow: 0;
      -webkit-flex-grow: 0;
      -ms-flex-grow: 0;
      flex-grow: 0;
      -moz-flex-shrink: 0;
      -webkit-flex-shrink: 0;
      -ms-flex-shrink: 0;
      flex-shrink: 0;
      width: 35%;
      min-width: 25rem;
      border-radius: 0;
      img {
        -moz-object-fit: cover;
        -webkit-object-fit: cover;
        -ms-object-fit: cover;
        object-fit: cover;
        -moz-object-position: center;
        -webkit-object-position: center;
        -ms-object-position: center;
        object-position: center;
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
      }
    }
  }
  .reverse {
    flex-direction: row-reverse;

    .content {
      border-radius: 0px 76px 76px 0px;
      background: #f6f6f6;
      box-shadow: 41px 21px 82px $primaryDark, -41px -41px 82px $base;
    }
  }
}

@media (max-width: 1680px) {
  .content {
    padding: 5rem 5rem 3rem 5rem;
  }
}

@media (max-width: 1280px) {
  .content {
    padding: 4rem 4rem 2rem 4rem;
  }
}

@media screen and (max-width: 960px) {
  p {
    margin: 0 0 1.5rem 0;
  }
  .home {
    h1 {
    font-size: 2.7rem;
    line-height: 1;
  }

    h2 {
      font-size: 1.75rem;
    }
    .banner {
      padding: 3.75rem 3.75rem 1.75rem 3.75rem;
      min-height: 100vh;
      -moz-align-items: center;
      -webkit-align-items: center;
      -ms-align-items: center;
      align-items: center;
      display: -moz-flex;
      display: -webkit-flex;
      display: -ms-flex;
      display: flex;
      -moz-justify-content: center;
      -webkit-justify-content: center;
      -ms-justify-content: center;
      justify-content: center;
      background-color: inherit;
      position: relative;
      text-align: center;
      overflow-x: hidden;

      p.major {
      font-size: 1rem;
    }

      p {
        font-size: 0.8rem;
      }

      .content {
        padding: 5.25rem 5.25rem 3.25rem 5.25rem;
        position: relative;
        width: 40rem;
        max-width: 100%;
        background-color: inherit;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        z-index: 1;
        background: #fff;
        transition: opacity 0.75s ease-in-out, transform 0.75s ease-in-out;
      }

      .image {
        -moz-flex-grow: 0;
        -webkit-flex-grow: 0;
        -ms-flex-grow: 0;
        flex-grow: 0;
        -moz-flex-shrink: 0;
        -webkit-flex-shrink: 0;
        -ms-flex-shrink: 0;
        flex-shrink: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        border-radius: 0;

        .logo {
          display: none;
        }
      }
    }
    .section1 {
      -moz-flex-direction: column-reverse;
      -webkit-flex-direction: column-reverse;
      -ms-flex-direction: column-reverse;
      flex-direction: column-reverse;
      height: 100vh;

      .content {
        height: 50%;
        border-radius: 0px 0px 76px 76px;
        margin: 0px 15px;
        padding: 2rem 5rem 3rem 5rem;
        max-height: 30vh;
      }

      .image {
        height: 50%;
        width: 100vw;
      }
    }
  }
}

@media screen and (max-width: 736px) {
  p {
    margin: 0 0 1rem 0;
  }
  .home {
    h2 {
      font-size: 1.4rem;
    }
    .banner {
      .content {
        padding: 2.5rem 1.5rem 0.5rem 1.5rem;
      }
    }
    .section1 {
      -moz-flex-direction: column-reverse;
      -webkit-flex-direction: column-reverse;
      -ms-flex-direction: column-reverse;
      flex-direction: column-reverse;
      height: 100vh;

      .content {
        height: 50%;
        border-radius: 0px 0px 76px 76px;
        margin: 0px 15px;
        padding: 2rem 3rem 3rem 3rem;
      }

      .image {
        height: 50%;
        width: 100vw;
      }
    }
  }
}
</style>