/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
public class Application
{
    private String name;
    private int applicationID;
    private String dateLastEdited;
    private String language;
    private String devUsername;
    private DynamicScreen[] appScreens;
    private Response [] responses;
    private GlobalData data;
    public Application(String name,int applicationID,String dateLastEdited,String language, String devUsername)
    {
        this.name=name;
        this.applicationID=applicationID;
        this.dateLastEdited=dateLastEdited;
        this.language=language;
        this.devUsername=devUsername;
        this.responses=null;
    }
    public void setAppScreens(DynamicScreen[] appScreens)
    {
        this.appScreens=appScreens;
    }
    public void startApplication(String fieldUser,String password,String host,Midlet midlet)
    {
        data=new GlobalData(appScreens, responses,fieldUser,password,host,applicationID,this.language,midlet);
        appScreens[0].setData(data);
        appScreens[0].show();
    }
}
