
CREATE TABLE `crm_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  
  PRIMARY KEY (`id`)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the crm_campaign table
CREATE TABLE `crm_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `social_media` varchar(255) NOT NULL,
  `admin_id` int(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`admin_id`) REFERENCES `crm_admin`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the crm_users table
CREATE TABLE `crm_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the crm_contact table
CREATE TABLE `crm_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_title` varchar(255) NOT NULL,
  `contact_first` varchar(255) NOT NULL,
  `contact_middle` varchar(255) NOT NULL,
  `contact_last` varchar(255) NOT NULL,
  `initial_contact_date` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL, -- Changed to varchar(20) to handle phone numbers with leading zeroes
  `email` varchar(50) NOT NULL,
  `status` enum('Lead','Proposal','Customer / won','Archive') NOT NULL,
  `website` varchar(255) NOT NULL,
  `sales_rep` int(11), 
  `project_type` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `proposal_due_date` varchar(255) NOT NULL,
  `budget` int(11) NOT NULL,
  `deliverables` varchar(255) NOT NULL,
  `campaign_id` int(11),
  FOREIGN KEY (`campaign_id`) REFERENCES `crm_campaign`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`sales_rep`) REFERENCES `crm_users`(`id`) ON DELETE SET NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the crm_tasks table
CREATE TABLE `crm_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `task_type` varchar(255) NOT NULL,
  `task_description` text NOT NULL,
  `task_due_date` date NOT NULL, -- Changed to date data type for better date handling
  `task_status` enum('Pending','Completed') NOT NULL,
  `task_update` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL,
  `sales_rep` int(11) NOT NULL,
  FOREIGN KEY (`contact`) REFERENCES `crm_contact`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`sales_rep`) REFERENCES `crm_users`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the crm_admin table


-- Insert data into the crm_campaign table
INSERT INTO `crm_campaign` (`name`, `start_date`, `end_date`, `description`, `status`, `social_media`) VALUES
('Winter Sale Campaign', '2024-03-05', '2024-05-29', 'Annual winter sale promotion', 'Active', 'Facebook'),
('Summer Promo', '2024-03-05', '2024-08-31', 'Summer promotional offer', 'Active', 'Instagram'),
('Spring Clearance', '2024-03-15', '2024-04-15', 'Clearance sale for spring season', 'Inactive', 'Twitter');

-- Insert data into the crm_users table
INSERT INTO `crm_users` (`name`, `email`, `password`, `status`) VALUES
('Ram', 'ram@gmail.com', '202cb962ac59075b964b07152d234b70', 1),
('Shyam', 'shyam@gmail.com', '202cb962ac59075b964b07152d234b70', 1),
('Hari', 'hari@gmail.com', '202cb962ac59075b964b07152d234b70', 1);

-- Insert data into the crm_contact table
INSERT INTO `crm_contact` (`contact_title`, `contact_first`, `contact_middle`, `contact_last`, `title`, `company`, `industry`, `address`, `city`, `state`, `country`, `zip`, `phone`, `email`, `status`, `website`, `sales_rep`, `project_type`, `project_description`, `proposal_due_date`, `budget`, `deliverables`, `campaign_id`) VALUES
('', 'David', '', 'Smith', '', 'ABC', 'Food', '', '', '', '', 0, '123456789', 'david@tes.com', 'Lead', 'www.testabc.com', 1, '', '', '', '15000', '', 1),
('', 'Goerge', '', 'Wood', '', 'XYZ', 'Motor', '', '', '', '', 0, '123456789', 'goerg@test.com', 'Lead', 'www.mtobc.com', 1, '', '', '', '0', '', 2),
('', 'adam', '', 'smith', '', 'vzxvzx', 'xzvzx', '', '', '', '', 0, '123456789', 'dgsdgsd@wty.com', 'Proposal', 'www.mtobc.com', 1, '', '', '', '0', '', 2),
('', 'xvzxxzv', '', 'xvzxvzxv', '', 'uyttyi', 'reyery', '', '', '', '', 0, '123456789', 'werwrwe@wr.com', 'Customer / won', 'www.fggg.com', 1, '', '', '', '3400', '', 1);

-- Insert data into the crm_tasks table
INSERT INTO `crm_tasks` (`created`, `task_type`, `task_description`, `task_due_date`, `task_status`, `task_update`, `contact`, `sales_rep`) VALUES
('2020-11-08 00:00:00', 'task', 'Lunch meeting', '2020-11-12', 'Pending', '', 1, 1),
('0000-00-00 00:00:00', '', 'phone calls', '2020-11-06', 'Pending', '', 2, 3),
('0000-00-00 00:00:00', '', 'Follow up email', '2020-11-05', 'Pending', '', 1, 1);

-- Insert data into the crm_admin table
INSERT INTO `crm_admin` (`name`, `email`, `password`, `status`) VALUES
('Sidd Pandit', 'sidd@gmail.com', '202cb962ac59075b964b07152d234b70', 1),
('Sovit Khatri', 'sovit@gmail.com', '202cb962ac59075b964b07152d234b70', 1);


-- Add triggers for the crm_campaign table
DELIMITER //

CREATE TRIGGER before_campaign_insert
BEFORE INSERT ON crm_campaign
FOR EACH ROW
BEGIN
    -- Check if the start_date is less than today's date
    IF NEW.start_date < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Start date must be today or a future date';
    END IF;

    -- Check if the end_date is less than today's date
    IF NEW.end_date < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'End date must be today or a future date';
    END IF;

    -- Check if the end_date is less than the start_date
    IF NEW.end_date < NEW.start_date THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'End date cannot be less than the start date';
    END IF;
END;
//

DELIMITER ;

DELIMITER //

DELIMITER //

-- CREATE TRIGGER before_campaign_status_update
-- BEFORE UPDATE ON crm_campaign
-- FOR EACH ROW
-- BEGIN
--     -- Check if the start_date is today or in the past and status is Active
--     IF NEW.start_date > CURDATE() AND NEW.status = 'Active' THEN
--         SIGNAL SQLSTATE '45000'
--         SET MESSAGE_TEXT = 'Cannot set status to Active for future start dates';
--     END IF;
-- END;
-- //

-- DELIMITER ;


