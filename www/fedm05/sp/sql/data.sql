-- First, let's insert some sample users
INSERT INTO users (username, email, password, role) VALUES
('chef_mario', 'mario@recipes.com', 'hashed_password_1', 'chef'),
('home_cook_sarah', 'sarah@email.com', 'hashed_password_2', 'user'),
('baker_john', 'john@bakery.com', 'hashed_password_3', 'baker'),
('admin_user', 'admin@recipes.com', 'hashed_password_4', 'admin');

-- Insert categories
INSERT INTO categories (name, type) VALUES
('Italian', 'Cuisine'),
('American', 'Cuisine'),
('Mexican', 'Cuisine'),
('Asian', 'Cuisine'),
('Mediterranean', 'Cuisine'),
('Indian', 'Cuisine'),
('French', 'Cuisine'),
('Breakfast', 'Meal'),
('Lunch', 'Meal'),
('Dinner', 'Meal'),
('Dessert', 'Meal'),
('Appetizer', 'Meal'),
('Vegetarian', 'Dietary'),
('Vegan', 'Dietary'),
('Gluten-Free', 'Dietary'),
('Keto', 'Dietary'),
('Healthy', 'Dietary'),
('Quick', 'Time'),
('Slow Cook', 'Time');

-- Insert units
INSERT INTO units (unit_name, unit_shortname) VALUES
('cup', 'cup'),
('tablespoon', 'tbsp'),
('teaspoon', 'tsp'),
('pound', 'lb'),
('ounce', 'oz'),
('gram', 'g'),
('kilogram', 'kg'),
('milliliter', 'ml'),
('liter', 'l'),
('piece', 'pc'),
('clove', 'clove'),
('slice', 'slice'),
('can', 'can'),
('package', 'pkg'),
('bunch', 'bunch');

-- Insert ingredients
INSERT INTO ingredients (name, category) VALUES
('all-purpose flour', 'Baking'),
('sugar', 'Baking'),
('brown sugar', 'Baking'),
('butter', 'Dairy'),
('eggs', 'Dairy'),
('milk', 'Dairy'),
('heavy cream', 'Dairy'),
('cheese', 'Dairy'),
('mozzarella cheese', 'Dairy'),
('parmesan cheese', 'Dairy'),
('olive oil', 'Oils'),
('vegetable oil', 'Oils'),
('salt', 'Seasonings'),
('black pepper', 'Seasonings'),
('garlic', 'Vegetables'),
('onion', 'Vegetables'),
('tomato', 'Vegetables'),
('bell pepper', 'Vegetables'),
('mushrooms', 'Vegetables'),
('spinach', 'Vegetables'),
('lettuce', 'Vegetables'),
('carrot', 'Vegetables'),
('celery', 'Vegetables'),
('potato', 'Vegetables'),
('chicken breast', 'Meat'),
('ground beef', 'Meat'),
('salmon', 'Fish'),
('shrimp', 'Seafood'),
('pasta', 'Grains'),
('rice', 'Grains'),
('bread', 'Grains'),
('tortilla', 'Grains'),
('basil', 'Herbs'),
('oregano', 'Herbs'),
('thyme', 'Herbs'),
('rosemary', 'Herbs'),
('cilantro', 'Herbs'),
('parsley', 'Herbs'),
('lemon', 'Citrus'),
('lime', 'Citrus'),
('Baking powder', 'Baking'),
('Baking soda', 'Baking'),
('vanilla extract', 'Extracts'),
('soy sauce', 'Condiments'),
('honey', 'Sweeteners'),
('maple syrup', 'Sweeteners'),
('coconut oil', 'Oils'),
('avocado', 'Vegetables'),
('banana', 'Fruits'),
('apple', 'Fruits'),
('strawberry', 'Fruits'),
('blueberry', 'Fruits'),
('orange', 'Citrus'),
('ginger', 'Spices'),
('cumin', 'Spices'),
('paprika', 'Spices'),
('chili powder', 'Spices'),
('cinnamon', 'Spices'),
('nutmeg', 'Spices'),
('vanilla', 'Extracts'),
('cocoa powder', 'Baking'),
('chocolate chips', 'Baking'),
('oats', 'Grains'),
('quinoa', 'Grains'),
('black beans', 'Legumes'),
('chickpeas', 'Legumes'),
('kidney beans', 'Legumes'),
('lentils', 'Legumes'),
('pork', 'Meat'),
('turkey', 'Meat'),
('bacon', 'Meat'),
('ham', 'Meat'),
('tuna', 'Fish'),
('cod', 'Fish'),
('broccoli', 'Vegetables'),
('cauliflower', 'Vegetables'),
('zucchini', 'Vegetables'),
('eggplant', 'Vegetables'),
('corn', 'Vegetables'),
('peas', 'Vegetables'),
('green beans', 'Vegetables'),
('asparagus', 'Vegetables'),
('sweet potato', 'Vegetables'),
('beets', 'Vegetables'),
('cabbage', 'Vegetables'),
('kale', 'Vegetables'),
('Brussels sprouts', 'Vegetables'),
('red wine', 'Alcohol'),
('white wine', 'Alcohol'),
('beer', 'Alcohol'),
('chicken Stock', 'Stocks'),
('beef Stock', 'Stocks'),
('vegetable Stock', 'Stocks'),
('tomato sauce', 'Sauces'),
('tomato paste', 'Sauces'),
('worcestershire sauce', 'Condiments'),
('hot sauce', 'Condiments'),
('mustard', 'Condiments'),
('mayonnaise', 'Condiments'),
('ketchup', 'Condiments'),
('vinegar', 'Condiments'),
('balsamic vinegar', 'Condiments'),
('red wine vinegar', 'Condiments'),
('sesame oil', 'Oils'),
('peanut oil', 'Oils'),
('sunflower oil', 'Oils');

-- Insert ingredient-unit relationships
INSERT INTO ingredients_units (ingredient_id, unit_id) VALUES
(1, 1), (1, 2), (1, 3), -- flour: cup, tbsp, tsp
(2, 1), (2, 2), (2, 3), -- sugar: cup, tbsp, tsp
(3, 1), (3, 2), (3, 3), -- brown sugar
(4, 1), (4, 2), (4, 3), (4, 5), -- butter
(5, 10), -- eggs: piece
(6, 1), (6, 8), -- milk
(7, 1), (7, 8), -- heavy cream
(8, 1), (8, 5), -- cheese
(9, 1), (9, 5), -- mozzarella
(10, 1), (10, 2), -- parmesan
(11, 1), (11, 2), (11, 3), -- olive oil
(12, 1), (12, 2), (12, 3), -- vegetable oil
(13, 2), (13, 3), -- salt
(14, 2), (14, 3), -- pepper
(15, 11), (15, 10), -- garlic: clove, piece
(16, 10), (16, 1), -- onion
(17, 10), (17, 1), -- tomato
(18, 10), (18, 1), -- bell pepper
(19, 1), (19, 5), -- mushrooms
(20, 1), (20, 15), -- spinach: bunch
(25, 4), (25, 5), -- chicken breast
(26, 4), (26, 5), -- ground beef
(27, 4), (27, 5), -- salmon
(28, 4), (28, 5), -- shrimp
(29, 4), (29, 5), (29, 1), -- pasta
(30, 1), (30, 5); -- rice

-- Insert 100 recipes
INSERT INTO recipes (name, difficulty, cooktime, portions, img, owner_user_id, description) VALUES
('Classic Spaghetti Carbonara', 'Medium', 20, 4, 'carbonara.jpg', 1, 'Authentic Italian pasta dish with eggs, cheese, and pancetta'),
('Chicken Tikka Masala', 'Hard', 45, 6, 'tikka_masala.jpg', 1, 'Creamy Indian curry with tender chicken pieces'),
('Beef Tacos', 'Easy', 25, 4, 'beef_tacos.jpg', 2, 'Traditional Mexican tacos with seasoned ground beef'),
('Caesar Salad', 'Easy', 15, 4, 'caesar_salad.jpg', 2, 'Classic salad with romaine, croutons, and parmesan'),
('Chocolate Chip Cookies', 'Easy', 30, 24, 'choc_cookies.jpg', 3, 'Soft and chewy homemade cookies'),
('Grilled Salmon', 'Medium', 20, 4, 'grilled_salmon.jpg', 1, 'Perfectly grilled salmon with Herbs and lemon'),
('Vegetable Stir Fry', 'Easy', 15, 4, 'veg_stirfry.jpg', 2, 'Quick and healthy mixed vegetable stir fry'),
('Pancakes', 'Easy', 20, 4, 'pancakes.jpg', 3, 'Fluffy American-style breakfast pancakes'),
('Beef Stew', 'Medium', 120, 6, 'beef_stew.jpg', 1, 'Hearty slow-cooked beef stew with Vegetables'),
('Margherita Pizza', 'Medium', 25, 4, 'margherita.jpg', 1, 'Classic Italian pizza with tomato, mozzarella, and basil'),
('Greek Salad', 'Easy', 10, 4, 'greek_salad.jpg', 2, 'Fresh Mediterranean salad with feta and olives'),
('Chicken Soup', 'Easy', 45, 6, 'chicken_soup.jpg', 2, 'Comforting homemade chicken soup'),
('Banana Bread', 'Easy', 65, 8, 'banana_bread.jpg', 3, 'Moist and delicious banana bread'),
('Pad Thai', 'Medium', 25, 4, 'pad_thai.jpg', 1, 'Popular Thai noodle dish with shrimp or chicken'),
('French Toast', 'Easy', 15, 4, 'french_toast.jpg', 3, 'Classic breakfast dish with cinnamon and vanilla'),
('Chili Con Carne', 'Medium', 90, 8, 'chili.jpg', 1, 'Spicy Mexican chili with beans and ground beef'),
('Caprese Salad', 'Easy', 10, 4, 'caprese.jpg', 2, 'Italian salad with tomatoes, mozzarella, and basil'),
('Chocolate Cake', 'Hard', 60, 12, 'choc_cake.jpg', 3, 'Rich and moist chocolate layer cake'),
('Fried Rice', 'Easy', 20, 4, 'fried_rice.jpg', 2, 'Asian-style fried rice with Vegetables and egg'),
('Lasagna', 'Hard', 90, 8, 'lasagna.jpg', 1, 'Layered Italian pasta dish with Meat and cheese'),
('Guacamole', 'Easy', 10, 6, 'guacamole.jpg', 2, 'Fresh Mexican avocado dip'),
('Chicken Alfredo', 'Medium', 30, 4, 'chicken_alfredo.jpg', 1, 'Creamy pasta dish with grilled chicken'),
('Apple Pie', 'Hard', 90, 8, 'apple_pie.jpg', 3, 'Classic American dessert with cinnamon apples'),
('Meatballs', 'Medium', 35, 6, 'meatballs.jpg', 1, 'Italian-style meatballs in tomato sauce'),
('Quinoa Salad', 'Easy', 25, 4, 'quinoa_salad.jpg', 2, 'Healthy grain salad with Vegetables and Herbs'),
('Brownies', 'Easy', 40, 16, 'brownies.jpg', 3, 'Fudgy chocolate brownies'),
('Chicken Parmesan', 'Medium', 40, 4, 'chicken_parm.jpg', 1, 'Breaded chicken with marinara and mozzarella'),
('Ratatouille', 'Medium', 45, 6, 'ratatouille.jpg', 2, 'French vegetable stew from Provence'),
('Lemon Bars', 'Medium', 50, 12, 'lemon_bars.jpg', 3, 'Tangy lemon dessert bars with shortbread crust'),
('Beef Burgers', 'Easy', 20, 4, 'burgers.jpg', 1, 'Juicy homemade beef burgers'),
('Minestrone Soup', 'Easy', 40, 6, 'minestrone.jpg', 2, 'Italian vegetable soup with pasta'),
('Cheesecake', 'Hard', 240, 12, 'cheesecake.jpg', 3, 'New York style baked cheesecake'),
('Shrimp Scampi', 'Medium', 20, 4, 'shrimp_scampi.jpg', 1, 'Garlic butter shrimp over pasta'),
('Stuffed Peppers', 'Medium', 50, 4, 'stuffed_peppers.jpg', 2, 'Bell peppers stuffed with rice and Meat'),
('Tiramisu', 'Hard', 240, 8, 'tiramisu.jpg', 3, 'Classic Italian coffee-flavored dessert'),
('Fish Tacos', 'Medium', 25, 4, 'fish_tacos.jpg', 1, 'Grilled Fish tacos with cabbage slaw'),
('Vegetable Curry', 'Medium', 35, 6, 'veg_curry.jpg', 2, 'Spicy Indian vegetable curry'),
('Oatmeal Cookies', 'Easy', 25, 24, 'oatmeal_cookies.jpg', 3, 'Chewy oatmeal raisin cookies'),
('Chicken Wings', 'Easy', 35, 4, 'chicken_wings.jpg', 1, 'Crispy baked chicken wings'),
('Gazpacho', 'Easy', 15, 4, 'gazpacho.jpg', 2, 'Cold Spanish tomato soup'),
('Peach Cobbler', 'Medium', 55, 8, 'peach_cobbler.jpg', 3, 'Southern-style fruit dessert'),
('Pork Chops', 'Medium', 25, 4, 'pork_chops.jpg', 1, 'Pan-seared pork chops with Herbs'),
('Hummus', 'Easy', 10, 8, 'hummus.jpg', 2, 'Middle Eastern chickpea dip'),
('Carrot Cake', 'Hard', 70, 12, 'carrot_cake.jpg', 3, 'Spiced cake with cream cheese frosting'),
('Teriyaki Chicken', 'Medium', 30, 4, 'teriyaki_chicken.jpg', 1, 'Japanese-style glazed chicken'),
('Coleslaw', 'Easy', 15, 6, 'coleslaw.jpg', 2, 'Creamy cabbage salad'),
('Chocolate Mousse', 'Hard', 180, 6, 'choc_mousse.jpg', 3, 'Light and airy chocolate dessert'),
('BBQ Ribs', 'Hard', 180, 4, 'bbq_ribs.jpg', 1, 'Slow-cooked barbecue pork ribs'),
('Tabbouleh', 'Easy', 20, 4, 'tabbouleh.jpg', 2, 'Middle Eastern parsley salad'),
('Vanilla Ice Cream', 'Hard', 240, 8, 'vanilla_ice_cream.jpg', 3, 'Homemade vanilla ice cream'),
('Lamb Curry', 'Hard', 90, 6, 'lamb_curry.jpg', 1, 'Aromatic Indian lamb curry'),
('Waldorf Salad', 'Easy', 15, 4, 'waldorf_salad.jpg', 2, 'Apple and celery salad with walnuts'),
('Pumpkin Pie', 'Medium', 75, 8, 'pumpkin_pie.jpg', 3, 'Traditional Thanksgiving dessert'),
('Chicken Fajitas', 'Medium', 25, 4, 'chicken_fajitas.jpg', 1, 'Mexican chicken and pepper strips'),
('Potato Salad', 'Easy', 30, 6, 'potato_salad.jpg', 2, 'Classic American potato salad'),
('Strawberry Shortcake', 'Medium', 40, 8, 'strawberry_shortcake.jpg', 3, 'Biscuits with strawberries and cream'),
('Salmon Teriyaki', 'Medium', 25, 4, 'salmon_teriyaki.jpg', 1, 'Glazed salmon with Asian flavors'),
('Spinach Salad', 'Easy', 10, 4, 'spinach_salad.jpg', 2, 'Fresh spinach with warm bacon dressing'),
('Bread Pudding', 'Medium', 60, 8, 'bread_pudding.jpg', 3, 'Comfort dessert with vanilla sauce'),
('Pork Tenderloin', 'Medium', 35, 6, 'pork_tenderloin.jpg', 1, 'Roasted pork with herb crust'),
('Chickpea Salad', 'Easy', 15, 4, 'chickpea_salad.jpg', 2, 'Protein-rich Mediterranean salad'),
('Key Lime Pie', 'Medium', 240, 8, 'key_lime_pie.jpg', 3, 'Tangy Florida-style dessert'),
('Turkey Meatballs', 'Medium', 30, 6, 'turkey_meatballs.jpg', 1, 'Lean turkey meatballs in sauce'),
('Beet Salad', 'Easy', 20, 4, 'beet_salad.jpg', 2, 'Roasted beet salad with goat cheese'),
('Chocolate Chip Muffins', 'Easy', 25, 12, 'choc_muffins.jpg', 3, 'Bakery-style chocolate chip muffins'),
('Cod Fish Cakes', 'Medium', 30, 4, 'fish_cakes.jpg', 1, 'Pan-fried cod patties'),
('Kale Salad', 'Easy', 15, 4, 'kale_salad.jpg', 2, 'Massaged kale with lemon dressing'),
('Lemon Cake', 'Medium', 55, 10, 'lemon_cake.jpg', 3, 'Bright Citrus layer cake'),
('Beef Brisket', 'Hard', 300, 8, 'beef_brisket.jpg', 1, 'Slow-smoked barbecue brisket'),
('Cucumber Salad', 'Easy', 10, 4, 'cucumber_salad.jpg', 2, 'Refreshing cucumber and dill salad'),
('Pecan Pie', 'Medium', 70, 8, 'pecan_pie.jpg', 3, 'Rich Southern nut pie'),
('Chicken Teriyaki', 'Medium', 25, 4, 'chicken_teriyaki.jpg', 1, 'Japanese-style glazed chicken thighs'),
('Arugula Salad', 'Easy', 10, 4, 'arugula_salad.jpg', 2, 'Peppery greens with vinaigrette'),
('Chocolate Tart', 'Hard', 180, 8, 'chocolate_tart.jpg', 3, 'Decadent chocolate ganache tart'),
('Pork Belly', 'Hard', 150, 6, 'pork_belly.jpg', 1, 'Crispy skin pork belly'),
('Farro Salad', 'Easy', 25, 4, 'farro_salad.jpg', 2, 'Ancient grain salad with Vegetables'),
('Blueberry Muffins', 'Easy', 25, 12, 'blueberry_muffins.jpg', 3, 'Bursting with fresh blueberries'),
('Halibut Steaks', 'Medium', 20, 4, 'halibut_steaks.jpg', 1, 'Pan-seared halibut with lemon'),
('Endive Salad', 'Easy', 10, 4, 'endive_salad.jpg', 2, 'Bitter greens with sweet dressing'),
('Coconut Cake', 'Hard', 65, 12, 'coconut_cake.jpg', 3, 'Tropical layer cake with coconut frosting'),
('Lamb Chops', 'Medium', 20, 4, 'lamb_chops.jpg', 1, 'Herb-crusted rack of lamb'),
('Watercress Salad', 'Easy', 10, 4, 'watercress_salad.jpg', 2, 'Peppery watercress with Citrus'),
('Red Velvet Cake', 'Hard', 75, 12, 'red_velvet.jpg', 3, 'Classic Southern cake with cream cheese frosting'),
('Duck Breast', 'Hard', 35, 4, 'duck_breast.jpg', 1, 'Pan-seared duck with cherry sauce'),
('Radicchio Salad', 'Easy', 10, 4, 'radicchio_salad.jpg', 2, 'Bitter Italian greens with balsamic'),
('Panna Cotta', 'Medium', 240, 6, 'panna_cotta.jpg', 3, 'Italian cream dessert with berry sauce'),
('Venison Steaks', 'Hard', 25, 4, 'venison_steaks.jpg', 1, 'Wild game steaks with juniper'),
('Fennel Salad', 'Easy', 15, 4, 'fennel_salad.jpg', 2, 'Shaved fennel with orange and olives'),
('Crème Brûlée', 'Hard', 180, 6, 'creme_brulee.jpg', 3, 'French custard with caramelized sugar'),
('Rabbit Stew', 'Hard', 120, 6, 'rabbit_stew.jpg', 1, 'Rustic French rabbit stew with wine'),
('Brussels Sprouts Salad', 'Easy', 15, 4, 'brussels_salad.jpg', 2, 'Shaved Brussels sprouts with bacon'),
('Soufflé', 'Hard', 45, 4, 'souffle.jpg', 3, 'Classic French cheese soufflé'),
('Quail', 'Hard', 30, 4, 'quail.jpg', 1, 'Roasted quail with Herbs'),
('Mache Salad', 'Easy', 10, 4, 'mache_salad.jpg', 2, 'Delicate lambs lettuce salad'),
('Mille-feuille', 'Hard', 180, 8, 'mille_feuille.jpg', 3, 'French Napoleon pastry with cream'),
('Foie Gras', 'Hard', 20, 4, 'foie_gras.jpg', 1, 'Pan-seared foie gras with fig'),
('Dandelion Salad', 'Easy', 10, 4, 'dandelion_salad.jpg', 2, 'Bitter greens with warm dressing'),
('Tarte Tatin', 'Hard', 90, 8, 'tarte_tatin.jpg', 3, 'Upside-down French apple tart'),
('Escargot', 'Hard', 25, 4, 'escargot.jpg', 1, 'French snails in garlic butter'),
('Purslane Salad', 'Easy', 10, 4, 'purslane_salad.jpg', 2, 'Succulent green salad with tomatoes'),
('Profiteroles', 'Hard', 90, 8, 'profiteroles.jpg', 3, 'Cream puffs with chocolate sauce'),
('Sweetbreads', 'Hard', 35, 4, 'sweetbreads.jpg', 1, 'Pan-fried veal sweetbreads'),
('Mizuna Salad', 'Easy', 10, 4, 'mizuna_salad.jpg', 2, 'Japanese mustard greens salad'),
('Croquembouche', 'Hard', 240, 12, 'croquembouche.jpg', 3, 'French cream puff tower'),
('Bone Marrow', 'Hard', 20, 4, 'bone_marrow.jpg', 1, 'Roasted bone marrow with Herbs'),
('Amaranth Salad', 'Easy', 15, 4, 'amaranth_salad.jpg', 2, 'Ancient grain salad with Vegetables');

-- Insert recipe categories (associating recipes with categories)
INSERT INTO recipe_categories (recipe_id, category_id) VALUES
-- Classic Spaghetti Carbonara
(1, 1), (1, 10), -- Italian, Dinner
-- Chicken Tikka Masala
(2, 6), (2, 10), -- Indian, Dinner
-- Beef Tacos
(3, 3), (3, 9), (3, 10), -- Mexican, Lunch, Dinner
-- Caesar Salad
(4, 2), (4, 9), (4, 12), -- American, Lunch, Appetizer
-- Chocolate Chip Cookies
(5, 2), (5, 11), -- American, Dessert
-- Grilled Salmon
(6, 5), (6, 10), (6, 17), -- Mediterranean, Dinner, Healthy
-- Vegetable Stir Fry
(7, 4), (7, 13), (7, 17), (7, 18), -- Asian, Vegetarian, Healthy, Quick
-- Pancakes
(8, 2), (8, 8), -- American, Breakfast
-- Beef Stew
(9, 2), (9, 10), (9, 19), -- American, Dinner, Slow Cook
-- Margherita Pizza
(10, 1), (10, 10), (10, 13), -- Italian, Dinner, Vegetarian
-- Greek Salad
(11, 5), (11, 9), (11, 13), (11, 17), -- Mediterranean, Lunch, Vegetarian, Healthy
-- Chicken Soup
(12, 2), (12, 9), (12, 10), (12, 17), -- American, Lunch, Dinner, Healthy
-- Banana Bread
(13, 2), (13, 8), (13, 11), -- American, Breakfast, Dessert
-- Pad Thai
(14, 4), (14, 10), -- Asian, Dinner
-- French Toast
(15, 7), (15, 8), -- French, Breakfast
-- Chili Con Carne
(16, 3), (16, 10), (16, 19), -- Mexican, Dinner, Slow Cook
-- Caprese Salad
(17, 1), (17, 12), (17, 13), (17, 18), -- Italian, Appetizer, Vegetarian, Quick
-- Chocolate Cake
(18, 2), (18, 11), -- American, Dessert
-- Fried Rice
(19, 4), (19, 9), (19, 10), (19, 18), -- Asian, Lunch, Dinner, Quick
-- Lasagna
(20, 1), (20, 10), -- Italian, Dinner
-- Guacamole
(21, 3), (21, 12), (21, 13), (21, 14), (21, 18), -- Mexican, Appetizer, Vegetarian, Vegan, Quick
-- Chicken Alfredo
(22, 1), (22, 10), -- Italian, Dinner
-- Apple Pie
(23, 2), (23, 11), -- American, Dessert
-- Meatballs
(24, 1), (24, 10), -- Italian, Dinner
-- Quinoa Salad
(25, 5), (25, 9), (25, 13), (25, 17), -- Mediterranean, Lunch, Vegetarian, Healthy
-- Brownies
(26, 2), (26, 11), -- American, Dessert
-- Chicken Parmesan
(27, 1), (27, 10), -- Italian, Dinner
-- Ratatouille
(28, 7), (28, 10), (28, 13), (28, 17), -- French, Dinner, Vegetarian, Healthy
-- Lemon Bars
(29, 2), (29, 11), -- American, Dessert
-- Beef Burgers
(30, 2), (30, 9), (30, 10), -- American, Lunch, Dinner
-- Minestrone Soup
(31, 1), (31, 9), (31, 13), (31, 17), -- Italian, Lunch, Vegetarian, Healthy
-- Cheesecake
(32, 2), (32, 11), -- American, Dessert
-- Shrimp Scampi
(33, 1), (33, 10), -- Italian, Dinner
-- Stuffed Peppers
(34, 2), (34, 10), -- American, Dinner
-- Tiramisu
(35, 1), (35, 11), -- Italian, Dessert
-- Fish Tacos
(36, 3), (36, 9), (36, 17), -- Mexican, Lunch, Healthy
-- Vegetable Curry
(37, 6), (37, 10), (37, 13), (37, 14), -- Indian, Dinner, Vegetarian, Vegan
-- Oatmeal Cookies
(38, 2), (38, 11), -- American, Dessert
-- Chicken Wings
(39, 2), (39, 12), -- American, Appetizer
-- Gazpacho
(40, 5), (40, 9), (40, 13), (40, 14), (40, 17), -- Mediterranean, Lunch, Vegetarian, Vegan, Healthy
-- Peach Cobbler
(41, 2), (41, 11), -- American, Dessert
-- Pork Chops
(42, 2), (42, 10), -- American, Dinner
-- Hummus
(43, 5), (43, 12), (43, 13), (43, 14), -- Mediterranean, Appetizer, Vegetarian, Vegan
-- Carrot Cake
(44, 2), (44, 11), -- American, Dessert
-- Teriyaki Chicken
(45, 4), (45, 10), -- Asian, Dinner
-- Coleslaw
(46, 2), (46, 9), (46, 17), -- American, Lunch, Healthy
-- Chocolate Mousse
(47, 7), (47, 11), -- French, Dessert
-- BBQ Ribs
(48, 2), (48, 10), (48, 19), -- American, Dinner, Slow Cook
-- Tabbouleh
(49, 5), (49, 9), (49, 13), (49, 14), (49, 17), -- Mediterranean, Lunch, Vegetarian, Vegan, Healthy
-- Vanilla Ice Cream
(50, 2), (50, 11), -- American, Dessert
-- Lamb Curry
(51, 6), (51, 10), -- Indian, Dinner
-- Waldorf Salad
(52, 2), (52, 9), -- American, Lunch
-- Pumpkin Pie
(53, 2), (53, 11), -- American, Dessert
-- Chicken Fajitas
(54, 3), (54, 10), -- Mexican, Dinner
-- Potato Salad
(55, 2), (55, 9), -- American, Lunch
-- Strawberry Shortcake
(56, 2), (56, 11), -- American, Dessert
-- Salmon Teriyaki
(57, 4), (57, 10), (57, 17), -- Asian, Dinner, Healthy
-- Spinach Salad
(58, 2), (58, 9), (58, 17), -- American, Lunch, Healthy
-- Bread Pudding
(59, 2), (59, 11), -- American, Dessert
-- Pork Tenderloin
(60, 2), (60, 10), -- American, Dinner
-- Chickpea Salad
(61, 5), (61, 9), (61, 13), (61, 14), (61, 17), -- Mediterranean, Lunch, Vegetarian, Vegan, Healthy
-- Key Lime Pie
(62, 2), (62, 11), -- American, Dessert
-- Turkey Meatballs
(63, 2), (63, 10), (63, 17), -- American, Dinner, Healthy
-- Beet Salad
(64, 5), (64, 9), (64, 13), (64, 17), -- Mediterranean, Lunch, Vegetarian, Healthy
-- Chocolate Chip Muffins
(65, 2), (65, 8), (65, 11), -- American, Breakfast, Dessert
-- Cod Fish Cakes
(66, 2), (66, 9), (66, 10), -- American, Lunch, Dinner
-- Kale Salad
(67, 2), (67, 9), (67, 13), (67, 14), (67, 17), -- American, Lunch, Vegetarian, Vegan, Healthy
-- Lemon Cake
(68, 2), (68, 11), -- American, Dessert
-- Beef Brisket
(69, 2), (69, 10), (69, 19), -- American, Dinner, Slow Cook
-- Cucumber Salad
(70, 5), (70, 9), (70, 13), (70, 17), (70, 18), -- Mediterranean, Lunch, Vegetarian, Healthy, Quick
-- Pecan Pie
(71, 2), (71, 11), -- American, Dessert
-- Chicken Teriyaki
(72, 4), (72, 10), -- Asian, Dinner
-- Arugula Salad
(73, 1), (73, 9), (73, 13), (73, 17), -- Italian, Lunch, Vegetarian, Healthy
-- Chocolate Tart
(74, 7), (74, 11), -- French, Dessert
-- Pork Belly
(75, 4), (75, 10), -- Asian, Dinner
-- Farro Salad
(76, 5), (76, 9), (76, 13), (76, 17), -- Mediterranean, Lunch, Vegetarian, Healthy
-- Blueberry Muffins
(77, 2), (77, 8), -- American, Breakfast
-- Halibut Steaks
(78, 2), (78, 10), (78, 17), -- American, Dinner, Healthy
-- Endive Salad
(79, 7), (79, 9), (79, 13), (79, 17), -- French, Lunch, Vegetarian, Healthy
-- Coconut Cake
(80, 2), (80, 11), -- American, Dessert
-- Lamb Chops
(81, 5), (81, 10), -- Mediterranean, Dinner
-- Watercress Salad
(82, 7), (82, 9), (82, 13), (82, 17), -- French, Lunch, Vegetarian, Healthy
-- Red Velvet Cake
(83, 2), (83, 11), -- American, Dessert
-- Duck Breast
(84, 7), (84, 10), -- French, Dinner
-- Radicchio Salad
(85, 1), (85, 9), (85, 13), (85, 17), -- Italian, Lunch, Vegetarian, Healthy
-- Panna Cotta
(86, 1), (86, 11), -- Italian, Dessert
-- Venison Steaks
(87, 7), (87, 10), -- French, Dinner
-- Fennel Salad
(88, 5), (88, 9), (88, 13), (88, 17), -- Mediterranean, Lunch, Vegetarian, Healthy
-- Crème Brûlée
(89, 7), (89, 11), -- French, Dessert
-- Rabbit Stew
(90, 7), (90, 10), (90, 19), -- French, Dinner, Slow Cook
-- Brussels Sprouts Salad
(91, 2), (91, 9), (91, 13), (91, 17), -- American, Lunch, Vegetarian, Healthy
-- Soufflé
(92, 7), (92, 10), (92, 13), -- French, Dinner, Vegetarian
-- Quail
(93, 7), (93, 10), -- French, Dinner
-- Mâche Salad
(94, 7), (94, 9), (94, 13), (94, 17), -- French, Lunch, Vegetarian, Healthy
-- Mille-feuille
(95, 7), (95, 11), -- French, Dessert
-- Foie Gras
(96, 7), (96, 12), -- French, Appetizer
-- Dandelion Salad
(97, 7), (97, 9), (97, 13), (97, 17), -- French, Lunch, Vegetarian, Healthy
-- Tarte Tatin
(98, 7), (98, 11), -- French, Dessert
-- Escargot
(99, 7), (99, 12), -- French, Appetizer
-- Purslane Salad
(100, 5), (100, 9), (100, 13), (100, 14), (100, 17); -- Mediterranean, Lunch, Vegetarian, Vegan, Healthy

-- Insert recipe ingredients with amounts and units
INSERT INTO recipe_ingredients (recipe_id, ingredient_id, amount, unit_id) VALUES
-- Recipe 1: Classic Spaghetti Carbonara
(1, 29, 1.00, 4), -- pasta, 1 lb
(1, 5, 4.00, 10), -- eggs, 4 pieces
(1, 10, 1.00, 1), -- parmesan cheese, 1 cup
(1, 67, 0.50, 4), -- bacon, 0.5 lb
(1, 15, 3.00, 11), -- garlic, 3 cloves
(1, 14, 1.00, 3), -- black pepper, 1 tsp
(1, 13, 1.00, 3), -- salt, 1 tsp

-- Recipe 2: Chicken Tikka Masala
(2, 25, 2.00, 4), -- chicken breast, 2 lbs
(2, 6, 1.00, 1), -- milk, 1 cup
(2, 17, 1.00, 13), -- tomato, 1 can
(2, 16, 1.00, 10), -- onion, 1 piece
(2, 15, 4.00, 11), -- garlic, 4 cloves
(2, 52, 1.00, 2), -- ginger, 1 tbsp
(2, 53, 2.00, 3), -- cumin, 2 tsp
(2, 55, 1.00, 3), -- chili powder, 1 tsp
(2, 7, 0.50, 1), -- heavy cream, 0.5 cup

-- Recipe 3: Beef Tacos
(3, 26, 1.00, 4), -- ground beef, 1 lb
(3, 32, 8.00, 10), -- tortilla, 8 pieces
(3, 16, 1.00, 10), -- onion, 1 piece
(3, 15, 2.00, 11), -- garlic, 2 cloves
(3, 53, 1.00, 2), -- cumin, 1 tbsp
(3, 55, 1.00, 2), -- chili powder, 1 tbsp
(3, 8, 1.00, 1), -- cheese, 1 cup
(3, 21, 2.00, 1), -- lettuce, 2 cups

-- Recipe 4: Caesar Salad
(4, 21, 2.00, 15), -- lettuce, 2 bunches
(4, 10, 0.50, 1), -- parmesan cheese, 0.5 cup
(4, 31, 2.00, 1), -- bread, 2 cups (croutons)
(4, 15, 2.00, 11), -- garlic, 2 cloves
(4, 39, 2.00, 10), -- lemon, 2 pieces
(4, 11, 0.25, 1), -- olive oil, 0.25 cup
(4, 5, 1.00, 10), -- eggs, 1 piece

-- Recipe 5: Chocolate Chip Cookies
(5, 1, 2.25, 1), -- all-purpose flour, 2.25 cups
(5, 41, 1.00, 3), -- Baking soda, 1 tsp
(5, 13, 1.00, 3), -- salt, 1 tsp
(5, 4, 1.00, 1), -- butter, 1 cup
(5, 3, 0.75, 1), -- brown sugar, 0.75 cup
(5, 2, 0.25, 1), -- sugar, 0.25 cup
(5, 5, 2.00, 10), -- eggs, 2 pieces
(5, 43, 2.00, 3), -- vanilla extract, 2 tsp
(5, 59, 2.00, 1), -- chocolate chips, 2 cups

-- Recipe 6: Grilled Salmon
(6, 27, 1.50, 4), -- salmon, 1.5 lbs
(6, 39, 2.00, 10), -- lemon, 2 pieces
(6, 11, 2.00, 2), -- olive oil, 2 tbsp
(6, 15, 2.00, 11), -- garlic, 2 cloves
(6, 33, 2.00, 2), -- basil, 2 tbsp
(6, 13, 1.00, 3), -- salt, 1 tsp
(6, 14, 0.50, 3), -- black pepper, 0.5 tsp

-- Recipe 7: Vegetable Stir Fry
(7, 18, 2.00, 10), -- bell pepper, 2 pieces
(7, 22, 2.00, 1), -- carrot, 2 cups
(7, 70, 2.00, 1), -- broccoli, 2 cups
(7, 19, 1.00, 1), -- mushrooms, 1 cup
(7, 16, 1.00, 10), -- onion, 1 piece
(7, 15, 3.00, 11), -- garlic, 3 cloves
(7, 52, 1.00, 2), -- ginger, 1 tbsp
(7, 44, 3.00, 2), -- soy sauce, 3 tbsp
(7, 12, 2.00, 2), -- vegetable oil, 2 tbsp

-- Recipe 8: Pancakes
(8, 1, 2.00, 1), -- all-purpose flour, 2 cups
(8, 2, 2.00, 2), -- sugar, 2 tbsp
(8, 41, 2.00, 3), -- Baking soda, 2 tsp
(8, 13, 1.00, 3), -- salt, 1 tsp
(8, 6, 1.75, 1), -- milk, 1.75 cups
(8, 5, 2.00, 10), -- eggs, 2 pieces
(8, 4, 0.25, 1), -- butter, 0.25 cup
(8, 43, 1.00, 3), -- vanilla extract, 1 tsp

-- Recipe 9: Beef Stew
(9, 26, 2.00, 4), -- ground beef, 2 lbs
(9, 24, 3.00, 10), -- potato, 3 pieces
(9, 22, 3.00, 10), -- carrot, 3 pieces
(9, 23, 2.00, 10), -- celery, 2 pieces
(9, 16, 1.00, 10), -- onion, 1 piece
(9, 15, 3.00, 11), -- garlic, 3 cloves
(9, 86, 4.00, 1), -- beef Stock, 4 cups
(9, 17, 1.00, 13), -- tomato, 1 can
(9, 35, 1.00, 2), -- thyme, 1 tbsp

-- Recipe 10: Margherita Pizza
(10, 1, 3.00, 1), -- all-purpose flour, 3 cups
(10, 9, 1.00, 1), -- mozzarella cheese, 1 cup
(10, 17, 0.50, 1), -- tomato, 0.5 cup (sauce)
(10, 33, 0.25, 1), -- basil, 0.25 cup
(10, 11, 2.00, 2), -- olive oil, 2 tbsp
(10, 15, 2.00, 11), -- garlic, 2 cloves
(10, 13, 1.00, 3), -- salt, 1 tsp

-- Continue with more recipes...
-- Recipe 11: Greek Salad
(11, 21, 1.00, 15), -- lettuce, 1 bunch
(11, 17, 3.00, 10), -- tomato, 3 pieces
(11, 8, 0.50, 1), -- cheese (feta), 0.5 cup
(11, 16, 0.50, 10), -- onion, 0.5 piece
(11, 11, 0.25, 1), -- olive oil, 0.25 cup
(11, 39, 1.00, 10), -- lemon, 1 piece
(11, 34, 1.00, 3), -- oregano, 1 tsp

-- Recipe 12: Chicken Soup
(12, 25, 1.00, 4), -- chicken breast, 1 lb
(12, 85, 6.00, 1), -- chicken Stock, 6 cups
(12, 22, 2.00, 10), -- carrot, 2 pieces
(12, 23, 2.00, 10), -- celery, 2 pieces
(12, 16, 1.00, 10), -- onion, 1 piece
(12, 29, 1.00, 1), -- pasta, 1 cup
(12, 15, 2.00, 11), -- garlic, 2 cloves
(12, 38, 2.00, 2), -- parsley, 2 tbsp

-- Recipe 13: Banana Bread
(13, 49, 3.00, 10), -- banana, 3 pieces
(13, 1, 1.75, 1), -- all-purpose flour, 1.75 cups
(13, 2, 0.75, 1), -- sugar, 0.75 cup
(13, 5, 1.00, 10), -- eggs, 1 piece
(13, 4, 0.33, 1), -- butter, 0.33 cup
(13, 41, 1.00, 3), -- Baking soda, 1 tsp
(13, 13, 0.50, 3), -- salt, 0.5 tsp
(13, 43, 1.00, 3), -- vanilla extract, 1 tsp

-- Recipe 14: Pad Thai
(14, 30, 8.00, 5), -- rice (noodles), 8 oz
(14, 28, 0.50, 4), -- shrimp, 0.5 lb
(14, 5, 2.00, 10), -- eggs, 2 pieces
(14, 44, 3.00, 2), -- soy sauce, 3 tbsp
(14, 45, 2.00, 2), -- honey, 2 tbsp
(14, 40, 1.00, 10), -- lime, 1 piece
(14, 18, 1.00, 10), -- bell pepper, 1 piece
(14, 16, 1.00, 10), -- onion, 1 piece

-- Recipe 15: French Toast
(15, 31, 8.00, 12), -- bread, 8 slices
(15, 5, 4.00, 10), -- eggs, 4 pieces
(15, 6, 0.50, 1), -- milk, 0.5 cup
(15, 2, 2.00, 2), -- sugar, 2 tbsp
(15, 43, 1.00, 3), -- vanilla extract, 1 tsp
(15, 56, 1.00, 3), -- cinnamon, 1 tsp
(15, 4, 2.00, 2), -- butter, 2 tbsp

-- Recipe 16: Chili Con Carne
(16, 26, 1.00, 4), -- ground beef, 1 lb
(16, 63, 1.00, 13), -- kidney beans, 1 can
(16, 17, 1.00, 13), -- tomato, 1 can
(16, 16, 1.00, 10), -- onion, 1 piece
(16, 15, 3.00, 11), -- garlic, 3 cloves
(16, 55, 2.00, 2), -- chili powder, 2 tbsp
(16, 53, 1.00, 2), -- cumin, 1 tbsp
(16, 54, 1.00, 3), -- paprika, 1 tsp

-- Recipe 17: Caprese Salad
(17, 17, 4.00, 10), -- tomato, 4 pieces
(17, 9, 8.00, 5), -- mozzarella cheese, 8 oz
(17, 33, 0.25, 1), -- basil, 0.25 cup
(17, 11, 3.00, 2), -- olive oil, 3 tbsp
(17, 13, 0.50, 3), -- salt, 0.5 tsp
(17, 14, 0.25, 3), -- black pepper, 0.25 tsp

-- Recipe 18: Chocolate Cake
(18, 1, 2.00, 1), -- all-purpose flour, 2 cups
(18, 2, 2.00, 1), -- sugar, 2 cups
(18, 58, 0.75, 1), -- cocoa powder, 0.75 cup
(18, 41, 2.00, 3), -- Baking soda, 2 tsp
(18, 40, 1.00, 3), -- Baking powder, 1 tsp
(18, 5, 2.00, 10), -- eggs, 2 pieces
(18, 6, 1.00, 1), -- milk, 1 cup
(18, 12, 0.50, 1), -- vegetable oil, 0.5 cup

-- Recipe 19: Fried Rice
(19, 30, 3.00, 1), -- rice, 3 cups (cooked)
(19, 5, 3.00, 10), -- eggs, 3 pieces
(19, 22, 1.00, 1), -- carrot, 1 cup
(19, 76, 1.00, 1), -- peas, 1 cup
(19, 16, 1.00, 10), -- onion, 1 piece
(19, 15, 2.00, 11), -- garlic, 2 cloves
(19, 44, 3.00, 2), -- soy sauce, 3 tbsp
(19, 12, 2.00, 2), -- vegetable oil, 2 tbsp

-- Recipe 20: Lasagna
(20, 29, 1.00, 4), -- pasta, 1 lb
(20, 26, 1.00, 4), -- ground beef, 1 lb
(20, 87, 2.00, 1), -- tomato sauce, 2 cups
(20, 9, 2.00, 1), -- mozzarella cheese, 2 cups
(20, 10, 1.00, 1), -- parmesan cheese, 1 cup
(20, 16, 1.00, 10), -- onion, 1 piece
(20, 15, 3.00, 11), -- garlic, 3 cloves
(20, 33, 2.00, 2), -- basil, 2 tbsp

-- Continue with remaining recipes up to 100...
-- Recipe 21: Guacamole
(21, 48, 4.00, 10), -- avocado, 4 pieces
(21, 40, 2.00, 10), -- lime, 2 pieces
(21, 16, 0.25, 10), -- onion, 0.25 piece
(21, 15, 2.00, 11), -- garlic, 2 cloves
(21, 37, 2.00, 2), -- cilantro, 2 tbsp
(21, 13, 0.50, 3), -- salt, 0.5 tsp
(21, 17, 1.00, 10), -- tomato, 1 piece

-- Recipe 22: Chicken Alfredo
(22, 25, 1.50, 4), -- chicken breast, 1.5 lbs
(22, 29, 1.00, 4), -- pasta, 1 lb
(22, 7, 1.00, 1), -- heavy cream, 1 cup
(22, 10, 1.00, 1), -- parmesan cheese, 1 cup
(22, 4, 0.50, 1), -- butter, 0.5 cup
(22, 15, 3.00, 11), -- garlic, 3 cloves
(22, 13, 1.00, 3), -- salt, 1 tsp
(22, 14, 0.50, 3), -- black pepper, 0.5 tsp

-- Recipe 23: Apple Pie
(23, 50, 6.00, 10), -- apple, 6 pieces
(23, 1, 2.50, 1), -- all-purpose flour, 2.5 cups
(23, 2, 0.75, 1), -- sugar, 0.75 cup
(23, 4, 1.00, 1), -- butter, 1 cup
(23, 56, 1.00, 3), -- cinnamon, 1 tsp
(23, 57, 0.25, 3), -- nutmeg, 0.25 tsp
(23, 13, 1.00, 3), -- salt, 1 tsp
(23, 5, 1.00, 10), -- eggs, 1 piece

-- Recipe 24: Meatballs
(24, 26, 1.00, 4), -- ground beef, 1 lb
(24, 31, 1.00, 1), -- bread, 1 cup (breadcrumbs)
(24, 5, 1.00, 10), -- eggs, 1 piece
(24, 6, 0.50, 1), -- milk, 0.5 cup
(24, 16, 1.00, 10), -- onion, 1 piece
(24, 15, 2.00, 11), -- garlic, 2 cloves
(24, 87, 2.00, 1), -- tomato sauce, 2 cups
(24, 33, 1.00, 2), -- basil, 1 tbsp

-- Recipe 25: Quinoa Salad
(25, 61, 1.00, 1), -- quinoa, 1 cup
(25, 17, 2.00, 10), -- tomato, 2 pieces
(25, 22, 1.00, 10), -- carrot, 1 piece
(25, 18, 1.00, 10), -- bell pepper, 1 piece
(25, 16, 0.50, 10), -- onion, 0.5 piece
(25, 37, 0.25, 1), -- cilantro, 0.25 cup
(25, 39, 2.00, 10), -- lemon, 2 pieces
(25, 11, 0.25, 1); -- olive oil, 0.25 cup


UPDATE recipes SET description=" Dorem ipsum solor it amet, consectetur adipiscing elit. Fusce vehicula nunc non velit ultrices, ut tempor sapien consequat. \n Integer dignissim nisi a purus dignissim, a semper tortor vehicula. Cras ut luctus velit. Pellentesque sed sapien purus. \n Suspendisse potenti. Nulla facilisi. In vel nunc sed sapien facilisis ultrices at id sapien. \n Vestibulum a arcu vel ex tincidunt laoreet. Quisque lacinia magna id libero euismod tincidunt. \n Sed ornare, risus eget tincidunt pretium, nisi lorem tristique orci, ut egestas sapien lacus nec nisl. ";

-- Insert sample user favorites for testing
INSERT INTO user_favorites (user_id, recipe_id) VALUES
-- chef_mario's favorites
(1, 1), (1, 6), (1, 10), (1, 15), (1, 20), (1, 25), (1, 30), (1, 35), (1, 40), (1, 45),
-- home_cook_sarah's favorites  
(2, 2), (2, 7), (2, 12), (2, 17), (2, 22), (2, 27), (2, 32), (2, 37), (2, 42), (2, 47),
-- baker_john's favorites
(3, 5), (3, 11), (3, 18), (3, 23), (3, 26), (3, 29), (3, 38), (3, 50), (3, 53), (3, 74),
-- admin_user's favorites
(4, 3), (4, 8), (4, 13), (4, 19), (4, 24), (4, 28), (4, 33), (4, 39), (4, 44), (4, 49);