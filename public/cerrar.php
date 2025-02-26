<?php
				session_start();
				session_unset();
				unset($_SESSION['OSSN_USER']);
				@session_destroy();
				$_SESSION['OSSN_USER'] = false;
				
?>