function store(id, obj, type)
{
	switch (type)
	{
		case "planets":
			store_planet(id, obj);
		break;
	}
}


function store_planet(id, obj)
{	
	if (planets_cache.length >= planets_cache_max + 1)
	{
		planets_cache.shift();
	}
	
	planets_cache[id] = obj;
}