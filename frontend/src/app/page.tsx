'use client';

import React, { useState, useEffect } from 'react';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from "@/components/ui/alert-dialog";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { PlusCircle, Pencil, Trash2, CreditCard, ChevronDown, ChevronUp } from 'lucide-react';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

interface Card {
  id: number;
  numero: string;
  data_validade: string;
  cvv: string;
  usuario_id: number;
}

interface User {
  id: number;
  nome: string;
  sobrenome: string;
  email: string;
  endereco: string;
  telefone: string;
  data_nascimento: string;
  cartoes: Card[];
}

export default function Home() {
  const [users, setUsers] = useState<User[]>([]);
  const [isAddModalOpen, setIsAddModalOpen] = useState(false);
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
  const [selectedUser, setSelectedUser] = useState<User | null>(null);
  const [formData, setFormData] = useState({
    nome: '',
    email: '',
    sobrenome: '',
    endereco: '',
    telefone: '',
    data_nascimento: '',
  });
  const [expandedUsers, setExpandedUsers] = useState<number[]>([]);
  const [isCardModalOpen, setIsCardModalOpen] = useState(false);
  const [isEditCardModalOpen, setIsEditCardModalOpen] = useState(false);
  const [isDeleteCardDialogOpen, setIsDeleteCardDialogOpen] = useState(false);
  const [selectedCard, setSelectedCard] = useState<Card | null>(null);
  const [cardFormData, setCardFormData] = useState({
    numero: '',
    data_validade: '',
    cvv: '',
    usuario_id: '',
  });

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    try {
      const response = await fetch('http://127.0.0.1:8001/api/usuarios');
      const data = await response.json();
      setUsers(data);
    } catch (error) {
      console.error('Erro ao buscar usuários:', error);
    }
  };

  const handleAddUser = async () => {
    if (formData.nome == '' || formData.email == '' || formData.sobrenome == '' || formData.endereco == '' || formData.telefone == '' || formData.data_nascimento == '') {
      toast.error('Preencha todos os dados do usuário antes de registra-lo.');
      return;
    }

    try {
      const response = await fetch('http://127.0.0.1:8001/api/usuarios', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });
      
      if (!response.ok) {
        throw new Error('Erro ao adicionar usuário');
      }
      
      setIsAddModalOpen(false);
      setFormData({ nome: '', email: '', sobrenome: '', endereco: '', telefone: '', data_nascimento: '', });
      fetchUsers();
    } catch (error) {
      console.error('Erro ao adicionar usuário:', error);
    }
  };

  const handleEditUser = async () => {
    if (!selectedUser) return;

    if (formData.nome == '' || formData.email == '' || formData.sobrenome == '' || formData.endereco == '' || formData.telefone == '' || formData.data_nascimento == '') {
      toast.error('Preencha todos os dados do usuário antes de alterar.');
      return;
    }

    try {
      const response = await fetch(`http://127.0.0.1:8001/api/usuarios/${selectedUser.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (!response.ok) {
        throw new Error('Erro ao editar usuário');
      }

      setIsEditModalOpen(false);
      setSelectedUser(null);
      setFormData({ nome: '', email: '', sobrenome: '', endereco: '', telefone: '', data_nascimento: '', });
      fetchUsers();
    } catch (error) {
      console.error('Erro ao editar usuário:', error);
    }
  };

  const handleDeleteUser = async () => {
    if (!selectedUser) return;
    try {
      const response = await fetch(`http://127.0.0.1:8001/api/usuarios/${selectedUser.id}`, {
        method: 'DELETE',
      });

      if (!response.ok) {
        throw new Error('Erro ao deletar usuário');
      }

      setIsDeleteDialogOpen(false);
      setSelectedUser(null);
      fetchUsers();
    } catch (error) {
      console.error('Erro ao deletar usuário:', error);
    }
  };

  const openEditModal = (user: User) => {
    setSelectedUser(user);
    setFormData({ 
      nome: user.nome, 
      email: user.email, 
      sobrenome: user.sobrenome, 
      endereco: user.endereco, 
      telefone: user.telefone, 
      data_nascimento: user.data_nascimento, 
    });
    setIsEditModalOpen(true);
  };

  const openDeleteDialog = (user: User) => {
    setSelectedUser(user);
    setIsDeleteDialogOpen(true);
  };

  const toggleUserExpansion = (userId: number) => {
    setExpandedUsers(prev =>
      prev.includes(userId)
        ? prev.filter(id => id !== userId)
        : [...prev, userId]
    );
  };

  const handleAddCard = async () => {
    if (cardFormData.numero == '' || cardFormData.data_validade == '' || cardFormData.usuario_id == '') {
      toast.error('Preencha todos os cartão do usuário antes de cria-lo.');
      return;
    }

    try {
      const response = await fetch('http://127.0.0.1:8001/api/cartoes', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(cardFormData),
      });
      
      if (!response.ok) {
        throw new Error('Erro ao adicionar cartão');
      }
      
      setIsCardModalOpen(false);
      setCardFormData({ numero: '', data_validade: '', cvv: '', usuario_id: '' });
      fetchUsers();
    } catch (error) {
      console.error('Erro ao adicionar cartão:', error);
    }
  };

  const handleEditCard = async () => {
    if (cardFormData.numero == '' || cardFormData.data_validade == '' || cardFormData.usuario_id == '') {
      toast.error('Preencha todos os cartão do usuário antes de alterar.');
      return;
    }

    if (!selectedCard) return;
    try {
      const response = await fetch(`http://127.0.0.1:8001/api/cartoes/${selectedCard.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(cardFormData),
      });

      if (!response.ok) {
        throw new Error('Erro ao editar cartão');
      }

      setIsEditCardModalOpen(false);
      setSelectedCard(null);
      setCardFormData({ numero: '', data_validade: '', cvv: '', usuario_id: '' });
      fetchUsers();
    } catch (error) {
      console.error('Erro ao editar cartão:', error);
    }
  };

  const handleDeleteCard = async () => {
    if (!selectedCard) return;
    try {
      const response = await fetch(`http://127.0.0.1:8001/api/cartoes/${selectedCard.id}`, {
        method: 'DELETE',
      });

      if (!response.ok) {
        throw new Error('Erro ao deletar cartão');
      }

      setIsDeleteCardDialogOpen(false);
      setSelectedCard(null);
      fetchUsers();
    } catch (error) {
      console.error('Erro ao deletar cartão:', error);
    }
  };

  const openAddCardModal = (userId: number) => {
    setCardFormData({ ...cardFormData, usuario_id: userId.toString() });
    setIsCardModalOpen(true);
  };

  const openEditCardModal = (card: Card) => {
    setSelectedCard(card);
    setCardFormData({
      numero: card.numero,
      data_validade: card.data_validade,
      cvv: card.cvv,
      usuario_id: card.usuario_id.toString(),
    });
    setIsEditCardModalOpen(true);
  };

  const openDeleteCardDialog = (card: Card) => {
    setSelectedCard(card);
    setIsDeleteCardDialogOpen(true);
  };

  return (
    <div className="container mx-auto p-8">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-bold">Gerenciamento de Usuários</h1>
        <Button onClick={() => setIsAddModalOpen(true)} className="flex items-center gap-2">
          <PlusCircle className="w-4 h-4" />
          Adicionar Usuário
        </Button>
      </div>

      <div className="bg-white rounded-lg shadow">
        <table className="w-full">
          <thead className="bg-gray-50">
            <tr>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nome
              </th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
              </th>
              <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ações
              </th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-200">
            {users.map((user) => (
              <React.Fragment key={user.id}>
                <>
                  <tr key={user.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="flex items-center">
                        <button
                          onClick={() => toggleUserExpansion(user.id)}
                          className="mr-2"
                        >
                          {expandedUsers.includes(user.id) ? (
                            <ChevronUp className="w-4 h-4" />
                          ) : (
                            <ChevronDown className="w-4 h-4" />
                          )}
                        </button>
                        {user.nome}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">{user.email}</td>
                    <td className="px-6 py-4 whitespace-nowrap text-right">
                      <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => openEditModal(user)}
                        className="mr-2"
                      >
                        <Pencil className="w-4 h-4" />
                      </Button>
                      <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => openDeleteDialog(user)}
                        className="text-red-600 hover:text-red-800 mr-2"
                      >
                        <Trash2 className="w-4 h-4" />
                      </Button>
                      <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => openAddCardModal(user.id)}
                      >
                        <CreditCard className="w-4 h-4" />
                      </Button>
                    </td>
                  </tr>
                  {expandedUsers.includes(user.id) && (
                    <tr>
                      <td colSpan={3} className="px-6 py-4">
                        <div className="pl-8">
                          <h4 className="font-medium mb-2">Cartões:</h4>
                          {user.cartoes.length === 0 ? (
                            <p className="text-gray-500">Nenhum cartão cadastrado</p>
                          ) : (
                            <div className="space-y-2">
                              {user.cartoes.map((card) => (
                                <div
                                  key={card.id}
                                  className="flex items-center justify-between bg-gray-50 p-3 rounded"
                                >
                                  <div>
                                    <p>Número: **** **** **** {card.numero.slice(-4)}</p>
                                    <p>Validade: {card.data_validade}</p>
                                  </div>
                                  <div>
                                    <Button
                                      variant="ghost"
                                      size="sm"
                                      onClick={() => openEditCardModal(card)}
                                      className="mr-2"
                                    >
                                      <Pencil className="w-4 h-4" />
                                    </Button>
                                    <Button
                                      variant="ghost"
                                      size="sm"
                                      onClick={() => openDeleteCardDialog(card)}
                                      className="text-red-600 hover:text-red-800"
                                    >
                                      <Trash2 className="w-4 h-4" />
                                    </Button>
                                  </div>
                                </div>
                              ))}
                            </div>
                          )}
                        </div>
                      </td>
                    </tr>
                  )}
                </>
              </React.Fragment>
            ))}
          </tbody>
        </table>
      </div>

      <Dialog open={isAddModalOpen} onOpenChange={setIsAddModalOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Adicionar Usuário</DialogTitle>
          </DialogHeader>
          <div className="space-y-4">
          <ToastContainer/>
            <div>
              <Label htmlFor="nome">Nome</Label>
              <Input
                id="nome"
                value={formData.nome}
                onChange={(e) => setFormData({ ...formData, nome: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="sobrenome">Sobrenome</Label>
              <Input
                id="sobrenome"
                value={formData.sobrenome}
                onChange={(e) => setFormData({ ...formData, sobrenome: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="email">Email</Label>
              <Input
                id="email"
                type="email"
                value={formData.email}
                onChange={(e) => setFormData({ ...formData, email: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="telefone">Telefone</Label>
              <Input
                id="telefone"
                value={formData.telefone}
                onChange={(e) => setFormData({ ...formData, telefone: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="endereco">Endereço</Label>
              <Input
                id="endereco"
                value={formData.endereco}
                onChange={(e) => setFormData({ ...formData, endereco: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="data_nascimento">Data de nascimento</Label>
              <Input
                id="data_nascimento"
                type="date"
                value={formData.data_nascimento}
                onChange={(e) => setFormData({ ...formData, data_nascimento: e.target.value })}
              />
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsAddModalOpen(false)}>
              Cancelar
            </Button>
            <Button onClick={handleAddUser}>Adicionar</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <Dialog open={isEditModalOpen} onOpenChange={setIsEditModalOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Editar Usuário</DialogTitle>
          </DialogHeader>
          <div className="space-y-4">
            <ToastContainer />
            <div>
              <Label htmlFor="edit-nome">Nome</Label>
              <Input
                id="edit-nome"
                required
                value={formData.nome}
                onChange={(e) => setFormData({ ...formData, nome: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="edit-sobrenome">Sobrenome</Label>
              <Input
                id="edit-sobrenome"
                required
                value={formData.sobrenome}
                onChange={(e) => setFormData({ ...formData, sobrenome: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="edit-email">Email</Label>
              <Input
                id="edit-email"
                type="email"
                required
                value={formData.email}
                onChange={(e) => setFormData({ ...formData, email: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="edit-endereco">Endereço</Label>
              <Input
                id="edit-endereco"
                required
                value={formData.endereco}
                onChange={(e) => setFormData({ ...formData, endereco: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="edit-telefone">Telefone</Label>
              <Input
                id="edit-telefone"
                required
                value={formData.telefone}
                onChange={(e) => setFormData({ ...formData, telefone: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="edit-data_nascimento">Data de nascimento</Label>
              <Input
                id="edit-data_nascimento"
                type="date"
                required
                value={formData.data_nascimento}
                onChange={(e) => setFormData({ ...formData, data_nascimento: e.target.value })}
              />
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsEditModalOpen(false)}>
              Cancelar
            </Button>
            <Button onClick={handleEditUser}>Salvar</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <AlertDialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
            <AlertDialogDescription>
              Esta ação não pode ser desfeita. Isso excluirá permanentemente o usuário
              {selectedUser && ` ${selectedUser.nome}`} e removerá seus dados do sistema.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancelar</AlertDialogCancel>
            <AlertDialogAction onClick={handleDeleteUser} className="bg-red-600 hover:bg-red-700">
              Excluir
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>

      <Dialog open={isCardModalOpen} onOpenChange={setIsCardModalOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Adicionar Cartão</DialogTitle>
          </DialogHeader>
          <div className="space-y-4">
          <ToastContainer />
            <div>
              <Label htmlFor="numero">Número do Cartão</Label>
              <Input
                id="numero"
                type='number'
                value={cardFormData.numero}
                onChange={(e) => setCardFormData({ ...cardFormData, numero: e.target.value })}
                maxLength={16}
              />
            </div>
            <div>
              <Label htmlFor="data_validade">Data de Validade</Label>
              <Input
                id="data_validade"
                type="date"
                value={cardFormData.data_validade}
                onChange={(e) => setCardFormData({ ...cardFormData, data_validade: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="cvv">CVV</Label>
              <Input
                id="cvv"
                type='number'
                value={cardFormData.cvv}
                onChange={(e) => setCardFormData({ ...cardFormData, cvv: e.target.value })}
                maxLength={3}
              />
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsCardModalOpen(false)}>
              Cancelar
            </Button>
            <Button onClick={handleAddCard}>Adicionar</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <Dialog open={isEditCardModalOpen} onOpenChange={setIsEditCardModalOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Editar Cartão</DialogTitle>
          </DialogHeader>
          <div className="space-y-4">
            <div>
            <ToastContainer />
              <Label htmlFor="edit-numero">Número do Cartão</Label>
              <Input
                id="edit-numero"
                type='number'
                value={cardFormData.numero}
                onChange={(e) => setCardFormData({ ...cardFormData, numero: e.target.value })}
                maxLength={16}
              />
            </div>
            <div>
              <Label htmlFor="edit-data_validade">Data de Validade</Label>
              <Input
                id="edit-data_validade"
                type="date"
                value={cardFormData.data_validade}
                onChange={(e) => setCardFormData({ ...cardFormData, data_validade: e.target.value })}
              />
            </div>
            <div>
              <Label htmlFor="edit-cvv">CVV</Label>
              <Input
                id="edit-cvv"
                type='number'
                value={cardFormData.cvv}
                onChange={(e) => setCardFormData({ ...cardFormData, cvv: e.target.value })}
                maxLength={3}
              />
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsEditCardModalOpen(false)}>
              Cancelar
            </Button>
            <Button onClick={handleEditCard}>Salvar</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <AlertDialog open={isDeleteCardDialogOpen} onOpenChange={setIsDeleteCardDialogOpen}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
            <AlertDialogDescription>
              Esta ação não pode ser desfeita. Isso excluirá permanentemente o cartão
              terminado em {selectedCard && selectedCard.numero.slice(-4)}.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancelar</AlertDialogCancel>
            <AlertDialogAction onClick={handleDeleteCard} className="bg-red-600 hover:bg-red-700">
              Excluir
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </div>
  );
}