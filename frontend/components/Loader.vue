<template>
	<span class="spinner">
		<span class="bounce1"></span>
		<span class="bounce2"></span>
		<span class="bounce3"></span>
	</span>
</template>
<style scoped>
	.spinner {
		width: 100%;
		text-align: center;
	}

	.spinner > span {
		width: 18px;
		height: 18px;
		background-color: #333;

		border-radius: 100%;
		display: inline-block;
		-webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
		animation: sk-bouncedelay 1.4s infinite ease-in-out both;
	}

	.spinner .bounce1 {
		-webkit-animation-delay: -0.32s;
		animation-delay: -0.32s;
	}

	.spinner .bounce2 {
		-webkit-animation-delay: -0.16s;
		animation-delay: -0.16s;
	}

	@-webkit-keyframes sk-bouncedelay {
		0%,
		80%,
		100% {
			-webkit-transform: scale(0);
		}
		40% {
			-webkit-transform: scale(1);
		}
	}

	@keyframes sk-bouncedelay {
		0%,
		80%,
		100% {
			-webkit-transform: scale(0);
			transform: scale(0);
		}
		40% {
			-webkit-transform: scale(1);
			transform: scale(1);
		}
	}
</style>