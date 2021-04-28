/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Stage.entities;

/**
 *
 * @author imote
 */
public class CandidatureStage {
    private int id;
    private int id_stage_id;
    private String nom;
    private String prenom;
    private String email;
    private int age;
    private String commentaire;

    public CandidatureStage() {
    }

    public CandidatureStage(int id, int id_stage_id, String nom, String prenom, String email, int age, String commentaire) {
        this.id = id;
        this.id_stage_id = id_stage_id;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.age = age;
        this.commentaire = commentaire;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getId_stage_id() {
        return id_stage_id;
    }

    public void setId_stage_id(int id_stage_id) {
        this.id_stage_id = id_stage_id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public String getCommentaire() {
        return commentaire;
    }

    public void setCommentaire(String commentaire) {
        this.commentaire = commentaire;
    }
   
   
    
}