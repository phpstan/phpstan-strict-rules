<?php

namespace BooleanInLogicalAnd;

class HelloWorld
{
	/** @return string|false */
	public function returnsStringOrFalse(){
		return false;
	}
	public function sayHello(): void
	{
		if(
			($response = $this->returnsStringOrFalse())
			and ($ip_geolocation_data = json_decode($response, true))
			and ($ip_geolocation_data['status'] !== 'fail')
			and (date_default_timezone_set($ip_geolocation_data['timezone']))
		){

		}
	}
}
