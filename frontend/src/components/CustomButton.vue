<template>
  <a href="#">
    <span><slot></slot></span>
    <div class="liquid"></div>
  </a>
</template>
<style lang="scss" scoped>

a {
	position: relative;
	padding: 20px 30px;
	display: block;
	text-decoration: none;
	text-transform: uppercase;
	width: 200px;
	overflow: hidden;
	border-radius: 40px;
	span {
		position: relative;
		color: #fff;
		font-size: 20px;
		font-family: Arial;
		letter-spacing: 8px;
		z-index: 1;
	}
	.liquid {
		position: absolute;
		top: -80px;
		left: 0;
		width: 300px;
		height: 200px;
		background: #4973ff;
		box-shadow: inset 0 0 50px rgba(0, 0, 0, .5);
		transition: .5s;
		&::after {
			content: '';
			width: 200%;
			height: 200%;
			position: absolute;
			top: 0;
			left: 50%;
			transform: translate(-50%, -75%);
			background: #000;
			border-radius: 40%;
			background: rgba(20, 20, 20, .5);
			animation: animate 10s linear infinite;
		}
		&::before {
			content: '';
			width: 200%;
			height: 200%;
			position: absolute;
			top: 0;
			left: 50%;
			transform: translate(-50%, -75%);
			background: #000;
			border-radius: 45%;
			background: rgba(20, 20, 20, 1);
			animation: animate 5s linear infinite;
		}
	}
	&:hover {
		.liquid {
			top: -120px;
		}
	}
}


@keyframes animate {
  0% {
    transform: translate(-60%, -85%) rotate(0deg);
  }
  100% {
    transform: translate(-60%, -85%) rotate(360deg);
  }
}
</style>