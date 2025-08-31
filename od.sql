Select c.name from categories c
join blog b 
where c.id = b.category
and b.id=1;