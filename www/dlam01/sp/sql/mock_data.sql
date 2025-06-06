-- Mock Data for Pet Shop Database

-- Insert data into animals table
INSERT INTO animals (name, description) VALUES
('Dog', 'Loyal companion animals with various breeds and sizes'),
('Cat', 'Independent and graceful felines with different coat patterns'),
('Bird', 'Feathered pets ranging from small parakeets to large parrots'),
('Fish', 'Aquatic pets for freshwater or saltwater aquariums'),
('Reptile', 'Cold-blooded animals including turtles, lizards, and snakes'),
('Small Mammal', 'Includes hamsters, guinea pigs, rabbits, and ferrets');

-- Insert data into categories table
INSERT INTO categories (name, description) VALUES
('Food', 'Nutritional products for various pets'),
('Toys', 'Entertainment and exercise items'),
('Housing', 'Cages, tanks, beds, and habitats'),
('Health', 'Medicines, supplements, and grooming products'),
('Accessories', 'Collars, leashes, bowls, and other pet gear');

-- Insert data into products table
INSERT INTO products (name, description, price, stock, image, category_id) VALUES
('Premium Dog Food', 'High-quality dry food for adult dogs, 20lb bag', 49.99, 100, 'dog_food.jpg', 1),
('Cat Scratching Post', '32-inch tall sisal-wrapped scratching post with base', 24.99, 50, 'scratch_post.jpg', 2),
('Bird Cage', 'Large wrought iron cage with 3 perches and feeders', 89.99, 30, 'bird_cage.jpg', 3),
('Aquarium Starter Kit', '10-gallon tank with filter, heater, and LED light', 99.99, 40, 'aquarium_kit.jpg', 3),
('Dog Flea Collar', 'Water-resistant flea and tick collar lasts 8 months', 19.99, 200, 'flea_collar.jpg', 4),
('Catnip Toy Set', 'Set of 3 catnip-filled plush toys in various shapes', 12.99, 75, 'catnip_toys.jpg', 2),
('Reptile Heat Lamp', '100W ceramic heat emitter for reptile habitats', 22.99, 60, 'heat_lamp.jpg', 3),
('Small Animal Exercise Wheel', 'Quiet 8.5-inch wheel for hamsters and mice', 15.99, 45, 'exercise_wheel.jpg', 2),
('Fish Food Flakes', 'Complete nutrition for tropical fish, 5oz container', 8.99, 120, 'fish_food.jpg', 1),
('Dog Leash', '6-foot durable nylon leash with padded handle', 14.99, 80, 'dog_leash.jpg', 5),
('Litter Box', 'Large covered litter box with odor filter', 29.99, 55, 'litter_box.jpg', 3),
('Bird Toy Bundle', 'Assorted colorful toys for medium to large birds', 18.99, 40, 'bird_toys.jpg', 2),
('Dog Bed', 'Orthopedic memory foam bed, large size', 59.99, 25, 'dog_bed.jpg', 3),
('Aquarium Decor', 'Assorted plants and ornaments for fish tanks', 16.99, 90, 'aquarium_decor.jpg', 5),
('Cat Dental Treats', 'Oral care treats that reduce plaque and tartar', 9.99, 150, 'dental_treats.jpg', 1);

-- Insert data into product_animals table (many-to-many relationships)
INSERT INTO product_animals (product_id, animal_id) VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 1),
(6, 2), (7, 5), (8, 6), (9, 4), (10, 1),
(11, 2), (12, 3), (13, 1), (14, 4), (15, 2);

-- Insert data into shipping_method table
INSERT INTO shipping_method (name, price) VALUES
('Standard Shipping', 5.99),
('Express Shipping', 12.99),
('In-Store Pickup', 0.00),
('Next Day Delivery', 19.99);

-- Insert data into orders table
INSERT INTO orders (user_id, date, status, shipping_method_id, shipping_price, total_price, city, street, zip_code) VALUES
(2, '2023-05-10 14:30:00', 2, 1, 5.99, 74.98, 'New York', '123 Main St', '10001'),
(3, '2023-05-12 09:15:00', 3, 2, 12.99, 102.97, 'Chicago', '456 Oak Ave', '60601'),
(4, '2023-05-15 16:45:00', 1, 3, 0.00, 89.99, 'Los Angeles', '789 Pine Rd', '90001'),
(5, '2023-05-18 11:20:00', 2, 1, 5.99, 42.98, 'Houston', '321 Elm St', '77001'),
(2, '2023-05-20 13:10:00', 4, 4, 19.99, 129.97, 'New York', '123 Main St', '10001');

-- Insert data into order_items table
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 49.99),
(1, 10, 1, 14.99),
(2, 3, 1, 89.99),
(3, 4, 1, 99.99),
(4, 6, 2, 12.99),
(4, 15, 1, 9.99),
(5, 13, 1, 59.99),
(5, 1, 1, 49.99),
(5, 10, 1, 14.99);

-- Insert data into reviews table
INSERT INTO reviews (user_id, product_id, comment, rating, created_at) VALUES
(2, 1, 'My dog loves this food! His coat looks shinier after just a few weeks.', 5, '2023-05-15 08:30:00'),
(3, 2, 'My cats use this every day. Much better than my furniture!', 4, '2023-05-14 12:45:00'),
(4, 4, 'Perfect starter kit for my first aquarium. Everything works great.', 5, '2023-05-17 16:20:00'),
(5, 6, 'My cat goes crazy for these toys. The mouse shape is her favorite.', 5, '2023-05-19 10:15:00'),
(2, 10, 'Good quality leash, but I wish it came in more colors.', 4, '2023-05-22 14:30:00'),
(3, 13, 'Very comfortable bed. My dog sleeps through the night now.', 5, '2023-05-23 09:45:00');

-- Mock orders for user_id 3
INSERT INTO orders (user_id, date, status, shipping_method_id, shipping_price, total_price, city, street, zip_code) VALUES
(3, '2023-06-05 11:30:00', 2, 2, 12.99, 87.97, 'Chicago', '456 Oak Ave', '60601'),
(3, '2023-06-12 14:45:00', 3, 1, 5.99, 62.98, 'Chicago', '456 Oak Ave', '60601'),
(3, '2023-06-20 09:15:00', 4, 4, 19.99, 178.96, 'Chicago', '789 Maple St', '60602');