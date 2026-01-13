<?php

class BankAccount
{
    private $balance = 0; // private property

    // Deposit money
    public function deposit($amount)
    {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Deposited $amount. Current balance: {$this->balance}<br>";
        } else {
            echo "Deposit amount must be positive.<br>";
        }
    }

    // Withdraw money
    public function withdraw($amount)
    {
        if ($amount > $this->balance) {
            echo "Cannot withdraw $amount. Insufficient balance: {$this->balance}<br>";
        } elseif ($amount <= 0) {
            echo "Withdraw amount must be positive.<br>";
        } else {
            $this->balance -= $amount;
            echo "Withdrew $amount. Current balance: {$this->balance}<br>";
        }
    }

    // Get current balance
    public function getBalance()
    {
        return $this->balance;
    }
}
$account = new BankAccount();

$account->deposit(100);    // Deposited 100
$account->withdraw(30);    // Withdrew 30
$account->withdraw(100);   // Cannot withdraw, insufficient balance
echo "Final Balance: " . $account->getBalance();
