<?php

    namespace Bookstore\Controllers;

    use Bookstore\Exceptions\NotFoundException;
    use Bookstore\Models\CustomerModel;

    class CustomerController extends AbstractController {
        public function login(): string {
            if (!$this->request->isPost())
                return $this->render('login.twig', []);

            $params = $this->request->getParams();

            if ($params->isEmpty('email')) {
                $params = ['errorMessage' => 'No info provided.'];
                return $this->render('login.twig', $params);
            }

            $email = $params->getString('email');
            $customerModel = new CustomerModel($this->db);

            try {
                $customer = $customerModel->getByEmail($email);
            } catch (NotFoundException $e) {
                $this->log->warn('Customer email not found: ' . $email);
                $params = ['errorMessage' => 'Email not found.'];
                return $this->render('login.twig', $params);
            }

            setcookie('user', $customer->getType());

            $newController = new BookController($this->request);
            return $newController->getAll();
        }
    }